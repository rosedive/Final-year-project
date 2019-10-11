<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Department;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\UserStatus;

use App\Repositories\Department\DepartmentRepository;
use App\Http\Requests\Department\CreateDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;

class DepartmentsController extends Controller
{
    private $departments;

    public function __construct(DepartmentRepository $departments)
    {
        $this->middleware('auth');
        $this->middleware('permission:department.manage');
        $this->departments = $departments;
    }

    public function index()
    {
        $departments = $this->departments->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        $statuses = ['' => 'All'] + UserStatus::lists();

        return view('department.index', compact('departments', 'statuses'));
    }

    public function create()
    {
        $edit = false;
        $hods = array();
        $users = User::orderBy('first_name', 'asc')->get();

        foreach ($users as $key => $value) {
            if($value->role->name == 'head_of_department')
                array_push($hods, $value);
        }

        return view('department.add-edit', compact('edit', 'hods'));
    }

    public function store(CreateDepartmentRequest $request)
    {
        $this->departments->create($request->all());

        return redirect()->route('department.index')
            ->withSuccess('Department created');
    }

    public function edit(Department $department)
    {
        $edit = true;
        $hods = array();
        $users = User::orderBy('first_name', 'asc')->get();

        foreach ($users as $key => $value) {
            if($value->role->name == 'head_of_department')
                array_push($hods, $value);
        }

        return view('department.add-edit', compact('edit', 'department', 'hods'));
    }

    public function update(Department $department, UpdateDepartmentRequest $request)
    {
        $this->departments->update($department->id, $request->all());

        return redirect()->route('department.index')
            ->withSuccess('Department updated');
    }

    public function delete(Department $department)
    {
        // if (! $department->removable) {
        //     throw new NotFoundHttpException;
        // }

        $this->departments->delete($department->id);

        Cache::flush();

        return redirect()->route('department.index')
            ->withSuccess('Department deleted');
    }
}