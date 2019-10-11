<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Authorization\AuthorizationRoleTrait;

class Notification extends Model
{
    use AuthorizationRoleTrait;

    protected $fillable = ['checking', 'created_by', 'message', 'request_id', 'date', 'time'];
}
