<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Authorization\AuthorizationRoleTrait;

class Finance extends Model
{
    use AuthorizationRoleTrait;

    protected $fillable = ['regno', 'bankslip_no', 'expected_amount', 'amount_paid', 'level'];
}
