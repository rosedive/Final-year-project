<?php

namespace App\Repositories\Hostel;

use App\Hostel;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentHostel implements HostelRepository
{
    public function find($id)
    {
        return Hostel::find($id);
    }

    public function create(array $data)
    {
        return Hostel::create($data);
    }

    public function paginate($perPage, $search = null, $status = null)
    {
        $query = Hostel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('hostels.regno', "like", "%{$search}%");
            });
        }

        $result = $query->join('users', 'hostels.regno', '=', 'users.username')
                    ->select('hostels.*', 'users.first_name', 'users.last_name')
                    ->orderBy('hostels.id', 'desc')
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
        $hostel = $this->find($id);

        $hostel->update($data);

        return $hostel;
    }

    public function delete($id)
    {
        $hostel = $this->find($id);

        return $hostel->delete();
    }

    public function count()
    {
        return Hostel::count();
    }
}
