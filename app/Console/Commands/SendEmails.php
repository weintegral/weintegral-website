<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VisitorRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecordMail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send each record data to the configured email address';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch all records from the database (or apply filtering as needed)
        $records = VisitorRequest::all();

        // Iterate through each record
        foreach ($records as $record) {
            // Prepare email data
            $email = $record->email;  // Replace with the email column or configured email
            $data = $record->toArray(); // You can customize the data you want to send

            // Send the email
            Mail::to($email)->send(new RecordMail($data));

            // Output to console for tracking
            $this->info("Email sent to {$email}");
        }
        return Command::SUCCESS;
    }
}
