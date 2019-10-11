<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Hostel;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\UserStatus;

use App\Repositories\Hostel\HostelRepository;
use App\Http\Requests\Hostel\CreateHostelRequest;
use App\Http\Requests\Hostel\UpdateHostelRequest;

class HostelsController extends Controller
{
    private $hostels;

    public function __construct(HostelRepository $hostels)
    {
        $this->middleware('auth');
        $this->middleware('permission:hostel.manage');
        $this->hostels = $hostels;
    }

    public function index()
    {
        $hostels = $this->hostels->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        $statuses = ['' => 'All'] + UserStatus::lists();

        return view('hostel.index', compact('hostels', 'statuses'));
    }

    public function create()
    {
        $edit = false;
        $hods = array();
        $users = User::orderBy('first_name', 'asc')->get();

        foreach ($users as $key => $value) {
            if($value->role->name == 'head_of_hostel')
                array_push($hods, $value);
        }

        return view('hostel.add-edit', compact('edit', 'hods'));
    }

    public function store(CreateHostelRequest $request)
    {
        $this->hostels->create($request->all());

        return redirect()->route('hostel.index')
            ->withSuccess('Hostel created');
    }

    public function edit(Hostel $hostel)
    {
        $edit = true;
        $hods = array();
        $users = User::orderBy('first_name', 'asc')->get();

        foreach ($users as $key => $value) {
            if($value->role->name == 'head_of_hostel')
                array_push($hods, $value);
        }

        return view('hostel.add-edit', compact('edit', 'hostel', 'hods'));
    }

    public function update(Hostel $hostel, UpdateHostelRequest $request)
    {
        $this->hostels->update($hostel->id, $request->all());

        return redirect()->route('hostel.index')
            ->withSuccess('Hostel updated');
    }

    public function delete(Hostel $hostel)
    {
        // if (! $hostel->removable) {
        //     throw new NotFoundHttpException;
        // }

        $this->hostels->delete($hostel->id);

        Cache::flush();

        return redirect()->route('hostel.index')
            ->withSuccess('Hostel deleted');
    }
}