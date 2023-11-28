<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\FireBaseTrait;

class SendNotiBeforeAt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, FireBaseTrait;

    private $event;
    private $userTokens = [];

    public function __construct($event, $userTokens)
    {
        $this->event = $event;
        $this->userTokens = $userTokens;
    }

    public function handle()
    {
        $event = $this->event;
        $userTokens = $this->userTokens;
        $notificationData = [
            'title' => $event->title,
            'body' => $event->description,
        ];

        $this->sendNotification($notificationData, $userTokens);
    }
}
