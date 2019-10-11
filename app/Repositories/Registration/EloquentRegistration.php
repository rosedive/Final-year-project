<?php

namespace App\Repositories\Registration;

use App\Registration;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentRegistration implements RegistrationRepository
{
    public function find($id)
    {
        return Registration::find($id);
    }

    public function create(array $data)
    {
        return Registration::create($data);
    }

    public function paginate($perPage, $search = null, $status = null)
    {
        $query = Registration::query();

        // if ($status) {
        //     $query->where('registrations.status', $status);
        // }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('registrations.regno', "like", "%{$search}%");
            });
        }

        $result = $query->join('users', 'registrations.regno', '=', 'users.username')
                    ->select('registrations.*', 'users.first_name', 'users.last_name')
                    ->orderBy('registrations.id', 'desc')
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
        $registration = $this->find($id);

        $registration->update($data);

        return $registration;
    }

    public function delete($id)
    {
        $registration = $this->find($id);

        return $registration->delete();
    }

    public function count()
    {
        return Registration::count();
    }
}
