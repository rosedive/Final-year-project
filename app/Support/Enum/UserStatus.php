<?php

namespace App\Support\Enum;

class UserStatus
{
    const UNCONFIRMED = 'Unconfirmed';
    const ACTIVE = 'Active';
    const BANNED = 'Banned';

    public static function lists()
    {
        return [
            self::ACTIVE => 'Active',
            self::BANNED => 'Banned',
            self::UNCONFIRMED => 'Unconfrimed'
        ];
    }
}
