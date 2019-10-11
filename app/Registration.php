<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Authorization\AuthorizationRoleTrait;

class Registration extends Model
{
    use AuthorizationRoleTrait;

    protected $fillable = ['regno', 'academic_year', 'promotion_year', 'level'];
}
