<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Authorization\AuthorizationRoleTrait;

class Department extends Model
{
    use AuthorizationRoleTrait;

    protected $fillable = ['name', 'hod'];

    public function users()
    {
        return $this->hasMany(User::class, 'department_id');
    }
}
