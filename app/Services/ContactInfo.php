<?php

namespace App\Services;

/**
 * The firm's contact details and offices, in one place for the whole site: the
 * shared Inertia props (HandleInertiaRequests), the Careers pages and the emails.
 */
class ContactInfo
{
    public function getPhoneNumber(): string
    {
        return '+1 (512) 774-6577';
    }

    public function getAdminEmailId(): string
    {
        return 'info@weintegral.com';
    }

    public function getHrEmailId(): string
    {
        return 'hr@weintegral.com';
    }

    /**
     * Each office with its postal address as display lines.
     *
     * @return list<array{name: string, addressLines: list<string>}>
     */
    public function offices(): array
    {
        return [
            [
                'name' => 'Corporate office',
                'addressLines' => ['2009 Ranch Road, 620 N STE 113,', 'Lakeway, TX 78734'],
            ],
            [
                'name' => 'Overseas office',
                'addressLines' => ['VIJAYA PG, Anjaiah Road,', 'Ongole,', 'Andhra Pradesh, India - 523001'],
            ],
        ];
    }
}
