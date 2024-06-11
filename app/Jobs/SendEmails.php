<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailDemo;

class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        
        $this->data = $data;
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = User::where('status',1)->where('is_email_verified','1')->get(); // Retrieve your users, adjust as needed
        $mailData= $this->data['mailData'];
        $hji= $this->data['hji'];   $subject = $this->data['subject'];    
        
        $chunkedUsers = $users->chunk(50); // Split users into chunks of 100
        foreach ($chunkedUsers as $chunk) {
            foreach ($chunk as $user) {
                Mail::to($user->email)->send(new EmailDemo($mailData,$hji,$subject)); // Send email using your Mailable
                 // sleep for half a second.
                
            }
        }
        
        return;
    }
}
