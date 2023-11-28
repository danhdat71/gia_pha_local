<?php

namespace App\Jobs;

use App\Models\UserToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\FireBaseTrait;
use Illuminate\Support\Facades\Log;

class SendNotiCreatedPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, FireBaseTrait;

    protected $familyTreeId = null;
    protected $notification = null;

    public function __construct($familyTreeId, $notification)
    {
        $this->familyTreeId = $familyTreeId;
        $this->notification = $notification;
    }

    public function handle()
    {
        $familyTreeId = $this->familyTreeId;
        $notification = $this->notification;
        // Get all users devices token
        $deviceTokens = UserToken::whereHas('user', function($q) use($familyTreeId) {
            $q->where('family_tree_id', $familyTreeId);
        })
        ->pluck('device_token')->toArray();

        $this->sendNotification($notification, $deviceTokens);
    }
}
