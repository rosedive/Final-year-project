<?php

namespace App\Support\Enum;

class LibraryStatus
{
    const BORROWED = 'borrowed';
    const FINALBOOK = 'finalbook';

    public static function lists()
    {
        return [
            self::BORROWED => 'Borrowed Books',
            self::FINALBOOK => 'Final year books',
        ];
    }
}
