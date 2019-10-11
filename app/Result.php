<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Authorization\AuthorizationRoleTrait;
use App\Support\Enum\RequestStatus;

class Result extends Model
{
    use AuthorizationRoleTrait;

    // protected $fillable = ['regno', 'level', 'term', 'marks'];
    protected $guarded = ['id'];
    protected $table = 'results';
}
