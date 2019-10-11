<?php

namespace App\Repositories\Library;

use App\Library;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\SQLiteConnection;

class EloquentLibrary implements LibraryRepository
{
    public function find($id)
    {
        return Library::find($id);
    }

    public function create(array $data)
    {
        return Library::create($data);
    }

    public function paginate($perPage, $search = null, $status = null)
    {
        $query = Library::query();

        if ($status) {
            $query->where('type', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('library.regno', "like", "%{$search}%");
            });
        }

        $result = $query->join('users', 'library.regno', '=', 'users.username')
                    ->select('library.*', 'users.first_name', 'users.last_name')
                    ->orderBy('library.id', 'desc')
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
        $library = $this->find($id);

        $library->update($data);

        return $library;
    }

    public function delete($id)
    {
        $library = $this->find($id);

        return $library->delete();
    }

    public function count()
    {
        return Library::count();
    }
}
