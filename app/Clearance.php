<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Authorization\AuthorizationRoleTrait;
use App\Support\Enum\RequestStatus;

class Clearance extends Model
{
    use AuthorizationRoleTrait;

    protected $fillable = ['level', 'regno', 'reason', 'hod_check', 'student_affair_check', 'library_check', 'adm_reg_check', 'finance_check', 'status'];


    public function isRequested()
    {
        return $this->status == RequestStatus::REQUESTED;
    }

    public function isProsessing()
    {
        return $this->status == RequestStatus::PROSESSING;
    }

    public function isRefused()
    {
        return $this->status == RequestStatus::REFUSED;
    }
}
