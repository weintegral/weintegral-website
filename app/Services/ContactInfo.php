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

    public function getCorporateAddress(): string
    {
        return <<< ADDRESS
            2009 Ranch Road, 620 N STE 113,<br>
            Lakeway, TX 78734
ADDRESS;
    }
}
