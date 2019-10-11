<?php

namespace App\Support\Enum;

class RequestStatus
{
    const REQUESTED = 'Requested';
    const PROSESSING = 'Processing';
    const APPROVED = 'Approved';
    const REFUSED = 'Refused';

    public static function lists()
    {
        return [
            self::REQUESTED => 'Requested',
            self::PROSESSING => 'Prosessing',
            self::APPROVED => 'Approved',
            self::REFUSED => 'Refused'
        ];
    }
}
