<?php

namespace App\Mail;

use App\Models\Schedule;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PresentationScheduled extends Mailable
{
    use Queueable, SerializesModels;

    public $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }

    public function build()
    {
        return $this->subject('FKPPS: Presentation Schedule Confirmed')
                    ->view('emails.scheduled');
    }
}
