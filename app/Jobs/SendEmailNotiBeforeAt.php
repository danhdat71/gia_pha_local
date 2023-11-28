<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailNotiBeforeAt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $event;
    private $userEmails = [];

    public function __construct($event, $userEmails = [])
    {
        $this->event = $event;
        $this->userEmails = $userEmails;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $event = $this->event;
        $userEmails = $this->userEmails;
        $inviteData = [
            'title' => $event->title,
            'description' => $event->description,
            'date' => $event->date,
            'eventTimes' => $event->eventTimes,
        ];

        Mail::send('mails.invite_event', $inviteData, function($mail) use($inviteData, $userEmails) {
            $mail->subject($inviteData['title']);
            $mail->to($userEmails);
        });
    }
}
