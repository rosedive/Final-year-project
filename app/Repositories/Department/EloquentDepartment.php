<?php

namespace App\Repositories\Department;

use App\Department;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentDepartment implements DepartmentRepository
{
    public function find($id)
    {
        return Department::find($id);
    }

    public function create(array $data)
    {
        return Department::create($data);
    }

    public function paginate($perPage, $search = null, $status = null)
    {
        $query = Department::query();

        // if ($status) {
        //     $query->where('departments.status', $status);
        // }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('departments.name', "like", "%{$search}%");
                $q->orWhere('departments.hod', 'like', "%{$search}%");
            });
        }

        $result = $query->join('users', 'departments.hod', '=', 'users.id')
                    ->select('departments.*', 'users.first_name', 'users.last_name')
                    ->orderBy('departments.id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $result->appends(['search' => $search]);
        }

        if ($status) {
            $result->appends(['status' => $status]);
        }

        return $result;
    }

    public function update($id, array $data)
    {
        $department = $this->find($id);

        $department->update($data);

        return $department;
    }

    public function delete($id)
    {
        $department = $this->find($id);

        return $department->delete();
    }

    public function count()
    {
        return Department::count();
    }
}
