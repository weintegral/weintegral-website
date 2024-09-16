<?php

namespace App\Services;

use App\Models\VisitorRequest;
use Dflydev\DotAccessData\Exception\DataException;
use http\Exception\RuntimeException;

class Visitor
{
    /**
     * @param array $data
     * @return void
     * @throws DataException
     */
    public function createRequest(array $data): void
    {
        try {
            $visitorRequest = new VisitorRequest();
            $visitorRequest->name = $data['name'];
            $visitorRequest->email = $data['email'];
            $visitorRequest->subject = $data['subject'];
            $visitorRequest->message = $data['message'];
            $visitorRequest->save();
        } catch (\Throwable) {
            throw new RuntimeException('Error creating visitor request');
        }
    }
}
