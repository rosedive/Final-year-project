<?php

namespace App\Repositories\Result;

use App\Result;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentResult implements ResultRepository
{
    public function find($id)
    {
        return Result::find($id);
    }

    public function create(array $data)
    {
        return Result::create($data);
    }

    public function paginate($perPage, $search = null, $status = null)
    {
        $query = Result::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('results.regno', "like", "%{$search}%");
                $q->orWhere('results.id', 'like', "%{$search}%");
            });
        }

        $result = $query
                    ->join('users', 'results.regno', '=', 'users.username')
                    ->select('results.*', 'users.first_name', 'users.last_name')
                    ->orderBy('results.id', 'desc')
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
        $result = $this->find($id);

        $result->update($data);

        return $result;
    }

    public function delete($id)
    {
        $result = $this->find($id);

        return $result->delete();
    }

    public function count()
    {
        return Result::count();
    }
}
