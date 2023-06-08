<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailDemo extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $hji, $subject)
    {
        //
        $this->mailData = $mailData;
        $this->filename = $hji;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('Email.demoEmail');
        //dd($this->filename);
        return $this->subject($this->subject)->markdown('Email.'.$this->filename)
              ->with('mailData', $this->mailData);
              
              
    }
}
