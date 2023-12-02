<?php

namespace App\Jobs\user;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\user\SendEmailVerification;
use Mail;

class SendEmailVerificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $destination;
    public $code;
  

    /**
     * Create a new job instance.
     */
    public function __construct($email, $code)
    {
        $this->destination = $email;
        $this->code = $code;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new SendEmailVerification($this->code);
        Mail::to($this->destination)->send($email);
    }
}
