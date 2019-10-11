<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Authorization\AuthorizationRoleTrait;

class Option extends Model
{
    use AuthorizationRoleTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dpt_options';

    protected $fillable = ['name', 'department_id'];

    public function users()
    {
        return $this->hasMany(User::class, 'option_id');
    }
}
