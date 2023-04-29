<?php

namespace App\Enums;

class TechIcons
{
    const PHP = 'https://cdn-icons-png.flaticon.com/512/2306/2306049.png';

    const NODEJS = 'https://cdn-icons-png.flaticon.com/512/5726/5726104.png';

    const SQL = 'https://cdn-icons-png.flaticon.com/512/4299/4299956.png';

    const JAVASCRIPT = 'https://cdn-icons-png.flaticon.com/512/2305/2305997.png';

    public static function getTechnologies()
    {
        return [
            'PHP' => self::PHP,
            'JAVASCRIPT' => self::JAVASCRIPT,
            'SQL' => self::SQL,
            'NODEJS' => self::NODEJS
        ];
    }

    public static function getIcon(string $tech): string
    {
        $technologies = self::getTechnologies();

        return $technologies[$tech];
    }
}
