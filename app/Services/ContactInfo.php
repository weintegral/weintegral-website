<?php

namespace App\Services;

class ContactInfo
{
    public function getPhoneNumber(): string
    {
        return '+1 (512) 774-6595';
    }

    public function getAdminEmailId(): string
    {
        return 'admin@weintegral.com';
    }

    public function getHrEmailId(): string
    {
        return 'hr@weintegral.com';
    }

    public function getAddress(): string
    {
        return <<< ADDRESS
            16 Central Square, Suite #2 <br>
            Bridgewater, MA 02324
ADDRESS;

    }
}
