<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Authorization\AuthorizationRoleTrait;

class Hostel extends Model
{
    use AuthorizationRoleTrait;

    protected $fillable = ['regno', 'room', 'sponsorship', 'expected_amount', 'amount_paid', 'contact', 'level'];
}
