<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Registration;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\UserStatus;

use App\Repositories\Registration\RegistrationRepository;
use App\Http\Requests\Registration\CreateRegistrationRequest;
use App\Http\Requests\Registration\UpdateRegistrationRequest;

class RegistrationsController extends Controller
{
    private $registrations;

    public function __construct(RegistrationRepository $registrations)
    {
        $this->middleware('auth');
        $this->middleware('permission:registration.manage');
        $this->registrations = $registrations;
    }

    public function index()
    {
        $registrations = $this->registrations->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        return view('registration.index', compact('registrations'));
    }

    public function create()
    {
        $edit = false;
        $hods = array();

        return view('registration.add-edit', compact('edit'));
    }

    public function store(CreateRegistrationRequest $request)
    {
        $this->registrations->create($request->all());

        return redirect()->route('registration.index')
            ->withSuccess('Registration created');
    }

    public function edit(Registration $registration)
    {
        $edit = true;

        return view('registration.add-edit', compact('edit', 'registration'));
    }

    public function update(Registration $registration, UpdateRegistrationRequest $request)
    {
        $this->registrations->update($registration->id, $request->all());

        return redirect()->route('registration.index')
            ->withSuccess('Registration updated');
    }

    public function delete(Registration $registration)
    {
        // if (! $registration->removable) {
        //     throw new NotFoundHttpException;
        // }

        $this->registrations->delete($registration->id);

        Cache::flush();

        return redirect()->route('registration.index')
            ->withSuccess('Registration deleted');
    }
}