<?php

namespace App\Console\Commands;

use App\Mail\VisitorRequestAcceptanceEmail;
use App\Mail\VisitorRequestProcessedEmail;
use App\Models\VisitorRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Command\Command as CommandAlias;

class VisitorRequestProcessor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitor:request-processor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process visitor requests and update the visitor status in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            // Get all the VisitorRequest records with status 'active' and 'progress'
            $visitorRequests = VisitorRequest::whereIn('status', ['active', 'progress'])->get();
            if ($visitorRequests === null) {
                return CommandAlias::SUCCESS;
            }

            $visitorRequests->each(function ($visitorRequest) {
                try {
                    // Email the visitor
                    Mail::to($visitorRequest->email)->send(new VisitorRequestAcceptanceEmail($visitorRequest->name));

                    // Email the admin
                    Mail::to('info@weintegral.com')
                        ->cc('s.gopibabu@gmail.com')
                        ->bcc('hr@weintegral.com')
                        ->send(new VisitorRequestProcessedEmail(
                            (string)$visitorRequest->name,
                            (string)$visitorRequest->email,
                            (string)$visitorRequest->subject,
                            (string)$visitorRequest->message
                        ));

                    // Update the status of the visitor request to 'resolved'
                    $visitorRequest->update(['status' => 'resolved']);
                } catch (\Throwable $e) {
                    Log::error('Error processing visitor request: ' . $e->getMessage());
                    $visitorRequest->update(['status' => 'progress']);
                }
            });
        } catch (\Throwable $e) {
            Log::error('Error processing visitor request from Database: ' . $e->getMessage());
            return CommandAlias::FAILURE;
        }

        return CommandAlias::SUCCESS;
    }
}
