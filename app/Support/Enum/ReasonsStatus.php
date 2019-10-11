<?php

namespace App\Support\Enum;

class ReasonsStatus
{
    const GRADUATION = 'graduation';
    const SUSPENSION = 'suspension';
    const ISSUE = 'issue_certificate';

    public static function lists()
    {
        return [
            self::GRADUATION => 'Graduation',
            self::SUSPENSION => 'Suspension / Postponent studies',
            self::ISSUE => 'Issue of certificate / To whom it may concern / Transcript / Diploma'
        ];
    }
}
