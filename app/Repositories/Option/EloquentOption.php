<?php

namespace App\Repositories\Option;

use App\Option;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentOption implements OptionRepository
{
    public function find($id)
    {
        return Option::find($id);
    }

    public function create(array $data)
    {
        return Option::create($data);
    }

    public function paginate($perPage, $search = null, $status = null)
    {
        $query = Option::query();

        // if ($status) {
        //     $query->where('dpt_options.status', $status);
        // }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('dpt_options.name', "like", "%{$search}%");
                $q->orWhere('department_id', 'like', "%{$search}%");
            });
        }

        $result = $query->join('departments', 'dpt_options.department_id', '=', 'departments.id')
                    ->select('dpt_options.*', 'departments.name as dpt_name')
                    ->orderBy('dpt_options.id', 'desc')
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
        $option = $this->find($id);

        $option->update($data);

        return $option;
    }

    public function delete($id)
    {
        $option = $this->find($id);

        return $option->delete();
    }

    public function count()
    {
        return Option::count();
    }
}
