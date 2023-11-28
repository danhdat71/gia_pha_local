<?php

namespace App\Traits;

use App\Constants\Status;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait FireBaseTrait
{
    public function sendNotification($dataNotification, $userTokens = [])
    {
        $notification = [
            'title' => $dataNotification['title'], 
            'body' => $dataNotification['body'],
            'type' => $dataNotification['type'] ?? null, 
            'sound' => 'default',
            'meta_data' => $dataNotification['meta_data'] ?? [],
            'badge' => Status::VALUE_TRUE,
            'click_action' => $dataNotification['link'] ?? env('APP_URL'),
        ];

        $dataToSend = [
            'registration_ids' => $userTokens,
            'notification' => $notification,
            'data' => $notification,
            'priority' => 'high',
        ];

        // Request send to Firebase
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'key='.env('FCM_KEY'),
        ])->post(env('FCM_URL'), $dataToSend);

        Log::channel('notification')->info('Request data: ' . json_encode($dataToSend, JSON_UNESCAPED_UNICODE));
        Log::channel('notification')->info('Response data: ' . json_encode($response->body(), JSON_UNESCAPED_UNICODE));
        
        return $response;
    }
}