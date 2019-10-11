<?php

namespace App\Repositories\Request;

use App\Clearance;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentRequest implements RequestRepository
{
    public function find($id)
    {
        return Clearance::find($id);
    }

    public function paginate($perPage, $search = null, $status = null)
    {
        // Current user role
        $role = auth()->user()->role->name;

        $query = Clearance::query();

        if ($status) {
            $query->where('clearances.status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('clearances.reason', "like", "%{$search}%");
                $q->orWhere('clearances.id', 'like', "%{$search}%");
            });
        }

        $result = $query
                    ->join('users', 'clearances.regno', '=', 'users.username')
                    ->select('clearances.*', 'users.first_name', 'users.last_name');

        switch ($role) {
            case 'head_of_department':
                // $result = $result->where('hod_check', 0);
                break;

            case 'director_of_student_affairs':
                // $result = $result->where(array('hod_check' => 1, 'student_affair_check' => 0));
                $result = $result->where(array('hod_check' => 1));
                break;

            case 'chief_of_library':
                // $result = $result->where(array('hod_check' => 1, 'student_affair_check' => 1, 'library_check' => 0));
                $result = $result->where(array('hod_check' => 1, 'student_affair_check' => 1));
                break;

            case 'admission_officer':
                // $result = $result->where(array('hod_check' => 1, 'student_affair_check' => 1, 'library_check' => 1, 'adm_reg_check' => 0));
                $result = $result->where(array('hod_check' => 1, 'student_affair_check' => 1, 'library_check' => 1));
                break;

            case 'income_controller':
                // $result = $result->where(array('hod_check' => 1, 'student_affair_check' => 1, 'library_check' => 1, 'adm_reg_check' => 1, 'finance_check' => 0));
                $result = $result->where(array('hod_check' => 1, 'student_affair_check' => 1, 'library_check' => 1, 'adm_reg_check' => 1));
                break;

        }

        $result = $result
                        ->orderBy('clearances.id', 'desc')
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
        $request = $this->find($id);

        $request->update($data);

        return $request;
    }

    public function count()
    {
        return Clearance::count();
    }
}
