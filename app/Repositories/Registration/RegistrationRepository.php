<?php

namespace App\Repositories\Registration;

use Carbon\Carbon;
use App\Registration;

interface RegistrationRepository
{
    public function paginate($perPage, $search = null, $status = null);

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function count();
}