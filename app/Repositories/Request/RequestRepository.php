<?php

namespace App\Repositories\Request;

use Carbon\Carbon;
use App\Clearance;

interface RequestRepository
{
    public function paginate($perPage, $search = null, $status = null);

    public function find($id);

    public function update($id, array $data);

    public function count();
}