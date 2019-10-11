<?php

namespace App\Http\Controllers\Web;

use App\Events\User\Banned;
use App\Events\User\Deleted;
use App\Events\User\TwoFactorDisabledByAdmin;
use App\Events\User\TwoFactorEnabledByAdmin;
use App\Events\User\UpdatedByAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\EnableTwoFactorRequest;
use App\Http\Requests\User\UpdateDetailsRequest;
use App\Http\Requests\User\UpdateLoginDetailsRequest;
use App\Http\Requests\User\UpdateStudentDetailsRequest;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Session\SessionRepository;
use App\Repositories\User\UserRepository;
use App\Services\Upload\UserAvatarManager;
use App\Support\Enum\UserStatus;
use App\User;
use App\Department;
use App\Option;
use Auth;
use Authy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->middleware('auth');
        $this->middleware('session.database', ['only' => ['sessions', 'invalidateSession']]);
        $this->middleware('permission:users.manage');
        $this->users = $users;
    }

    public function index()
    {
        $users = $this->users->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        $statuses = ['' => trans('app.all')] + UserStatus::lists();

        return view('user.list', compact('users', 'statuses'));
    }

    public function view(User $user, ActivityRepository $activities)
    {
        $userActivities = $activities->getLatestActivitiesForUser($user->id, 10);

        return view('user.view', compact('user', 'userActivities'));
    }

    public function create(RoleRepository $roleRepository)
    {
        $roles = $roleRepository->lists();
        $statuses = UserStatus::lists();
        $departments = Department::orderBy('name', 'asc')->get();

        return view('user.add', compact('roles', 'statuses', 'departments'));
    }

    public function store(CreateUserRequest $request)
    {
        // When user is created by administrator, we will set his
        // status to Active by default.
        $data = $request->all() + ['status' => UserStatus::ACTIVE];

        // Username should be updated only if it is provided.
        // So, if it is an empty string, then we just leave it as it is.
        if (trim($data['username']) == '') {
            $data['username'] = null;
        }

        $user = $this->users->create($data);

        return redirect()->route('user.list')
            ->withSuccess(trans('app.user_created'));
    }

    public function edit(User $user, RoleRepository $roleRepository)
    {
        $edit = true;
        $roles = $roleRepository->lists();
        $statuses = UserStatus::lists();
        $departments = Department::orderBy('name', 'asc')->get();
        $options = Option::orderBy('name', 'asc')->get();

        return view(
            'user.edit',
            compact('edit', 'user', 'roles', 'statuses', 'departments', 'options')
        );
    }

    public function updateDetails(User $user, UpdateDetailsRequest $request)
    {
        $data = $request->all();

        $this->users->update($user->id, $data);
        $this->users->setRole($user->id, $request->role_id);

        event(new UpdatedByAdmin($user));

        // If user status was updated to "Banned",
        // fire the appropriate event.
        if ($this->userIsBanned($user, $request)) {
            event(new Banned($user));
        }

        return redirect()->back()
            ->withSuccess(trans('app.user_updated'));
    }

    private function userIsBanned(User $user, Request $request)
    {
        return $user->status != $request->status && $request->status == UserStatus::BANNED;
    }

    public function updateAvatar(User $user, UserAvatarManager $avatarManager, Request $request)
    {
        $this->validate($request, ['avatar' => 'image']);

        $name = $avatarManager->uploadAndCropAvatar(
            $user,
            $request->file('avatar'),
            $request->get('points')
        );

        if ($name) {
            $this->users->update($user->id, ['avatar' => $name]);

            event(new UpdatedByAdmin($user));

            return redirect()->route('user.edit', $user->id)
                ->withSuccess(trans('app.avatar_changed'));
        }

        return redirect()->route('user.edit', $user->id)
            ->withErrors(trans('app.avatar_not_changed'));
    }

    public function updateAvatarExternal(User $user, Request $request, UserAvatarManager $avatarManager)
    {
        $avatarManager->deleteAvatarIfUploaded($user);

        $this->users->update($user->id, ['avatar' => $request->get('url')]);

        event(new UpdatedByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess(trans('app.avatar_changed'));
    }

    public function updateLoginDetails(User $user, UpdateLoginDetailsRequest $request)
    {
        $data = $request->all();

        if (trim($data['password']) == '') {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $this->users->update($user->id, $data);

        event(new UpdatedByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess(trans('app.login_updated'));
    }

    public function sd(User $user, UpdateStudentDetailsRequest $request)
    {
        $data = $request->all();

        $this->users->update($user->id, $data);

        event(new UpdatedByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess('Student details updated');
    }

    public function delete(User $user)
    {
        if ($user->id == Auth::id()) {
            return redirect()->route('user.list')
                ->withErrors(trans('app.you_cannot_delete_yourself'));
        }

        $this->users->delete($user->id);

        event(new Deleted($user));

        return redirect()->route('user.list')
            ->withSuccess(trans('app.user_deleted'));
    }

    public function disableTwoFactorAuth(User $user)
    {
        if (! Authy::isEnabled($user)) {
            return redirect()->route('user.edit', $user->id)
                ->withErrors(trans('app.2fa_not_enabled_user'));
        }

        Authy::delete($user);

        $user->save();

        event(new TwoFactorDisabledByAdmin($user));

        return redirect()->route('user.edit', $user->id)
            ->withSuccess(trans('app.2fa_disabled'));
    }

    public function sessions(User $user, SessionRepository $sessionRepository)
    {
        $adminView = true;
        $sessions = $sessionRepository->getUserSessions($user->id);

        return view('user.sessions', compact('sessions', 'user', 'adminView'));
    }

    public function invalidateSession(User $user, $session, SessionRepository $sessionRepository)
    {
        $sessionRepository->invalidateSession($session->id);

        return redirect()->route('user.sessions', $user->id)
            ->withSuccess(trans('app.session_invalidated'));
    }

    public function getOptions(Request $request)
    {
        $html = '';
        if( $request->dpt_id ) {
            $html = '<option value="">--select--</option>';
            $options = Option::where('department_id', $request->dpt_id)->orderBy('name', 'asc')->get();

            foreach ($options as $key => $option) {
                $html .= '<option value="'.$option->id.'">'.$option->name.'</option>';
            }
        }

        return $html;
    }
}
