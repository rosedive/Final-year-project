<?php

namespace App\Repositories\Result;

use Carbon\Carbon;
use App\Result;

interface ResultRepository
{
    public function paginate($perPage, $search = null, $status = null);

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function count();
}