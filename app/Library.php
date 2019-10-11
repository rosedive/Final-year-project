<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\Authorization\AuthorizationRoleTrait;
use App\Support\Enum\LibraryStatus;

class Library extends Model
{
    use AuthorizationRoleTrait;
    protected $table = 'library';

    protected $fillable = ['regno', 'book_title', 'book_isbn', 'type', 'status'];


    public function isBorrowed()
    {
        return $this->status == LibraryStatus::BORROWED;
    }

    public function isFinalbook()
    {
        return $this->status == LibraryStatus::FINALBOOK;
    }


}
