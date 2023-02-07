<?php

namespace App\Services;

class ContactInfo
{
    public function getPhoneNumber(): string
    {
        return '+1 (000) 000-0000';
    }

    public function getEmailId(): string
    {
        return 'admin@weintegral.com';
    }

    public function getAddress(): string
    {
        return <<< ADDRESS
            16 Central Square,
            Bridgewater, MA 02324
ADDRESS;

    }
}
