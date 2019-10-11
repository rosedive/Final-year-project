<?php

namespace App\Repositories\Clearance;

use App\Clearance;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentClearance implements ClearanceRepository
{
    public function find($id)
    {
        return Clearance::find($id);
    }

    public function create(array $data)
    {
        return Clearance::create($data);
    }

    public function paginate($perPage, $search = null, $status = null)
    {
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

        $result = $query->where('clearances.regno', auth()->user()->username)
                    ->join('users', 'clearances.regno', '=', 'users.username')
                    ->select('clearances.*', 'users.first_name', 'users.last_name')
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
        $clearance = $this->find($id);

        $clearance->update($data);

        return $clearance;
    }

    public function delete($id)
    {
        $clearance = $this->find($id);

        return $clearance->delete();
    }

    public function count()
    {
        return Clearance::count();
    }
}
