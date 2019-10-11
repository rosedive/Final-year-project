<?php

namespace App\Repositories\Finance;

use App\Finance;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentFinance implements FinanceRepository
{
    public function find($id)
    {
        return Finance::find($id);
    }

    public function create(array $data)
    {
        return Finance::create($data);
    }

    public function paginate($perPage, $search = null, $status = null)
    {
        $query = Finance::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('finances.regno', "like", "%{$search}%");
            });
        }

        $finance = $query
                    ->join('users', 'finances.regno', '=', 'users.username')
                    ->select('finances.*', 'users.first_name', 'users.last_name')
                    ->orderBy('finances.id', 'desc')
            ->paginate($perPage);

        if ($search) {
            $finance->appends(['search' => $search]);
        }

        if ($status) {
            $finance->appends(['status' => $status]);
        }

        return $finance;
    }

    public function update($id, array $data)
    {
        $finance = $this->find($id);

        $finance->update($data);

        return $finance;
    }

    public function delete($id)
    {
        $finance = $this->find($id);

        return $finance->delete();
    }

    public function count()
    {
        return Finance::count();
    }
}
