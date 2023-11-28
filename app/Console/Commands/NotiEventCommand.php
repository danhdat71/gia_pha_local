<?php

namespace App\Console\Commands;

use App\Constants\Status;
use App\Jobs\SendEmailNotiBeforeAt;
use App\Jobs\SendNotiBeforeAt;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Event;

class NotiEventCommand extends Command
{
    protected $signature = 'event:noti'; // php artisan event:noti
    protected $description = 'Send noti to join event members';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now()->format('1000-m-d H:i:00'); 
        $events = Event::where('is_year_loop', Status::VALUE_TRUE)
            ->where('noti_before_at', '=', $now)
            ->with(['eventTimes'])
            ->get();
        foreach($events as $event) {
            // Send mail notification
            $userEmails = $event->eventsUsers()->select()->pluck('email')->toArray();
            dispatch(new SendEmailNotiBeforeAt($event, $userEmails));
            // Send to user device notification
            $userTokens = UserToken::whereHas('user', function($q) use($event) {
                $q->whereHas('eventsUsers', function($q) use($event) {
                    $q->where('event_id', $event->id);
                });
            })->pluck('device_token')->toArray();
            dispatch(new SendNotiBeforeAt($event, $userTokens));
        }
    }
}
