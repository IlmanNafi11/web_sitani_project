<?php

namespace App\Notifications;

use Google\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $title;
    public string $pesan;
    public string $type;

    public function __construct(string $title, string $pesan, string $type)
    {
        $this->title = $title;
        $this->pesan = $pesan;
        $this->type = $type;
    }

    public function via(object $notifiable): array
    {
        $this->toFcm($notifiable);
        return ['database'];
    }

    public function toFcm(object $notifiable): void
    {
        if (!$notifiable->fcm_token) {
            Log::info("User {$notifiable->id} tidak memiliki token FCM.");
            return;
        }

        try {
            $client = new Client();
            $client->setAuthConfig(config('services.firebase.credentials'));
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->fetchAccessTokenWithAssertion();

            $accessToken = $client->getAccessToken()['access_token'] ?? null;

            if (!$accessToken) {
                Log::error("Gagal mengambil access token dari Firebase.");
                return;
            }

            $url = "https://fcm.googleapis.com/v1/projects/" . config('services.firebase.project_id') . "/messages:send";

            $message = [
                'message' => [
                    'token' => $notifiable->fcm_token,
                    'notification' => [
                        'title' => $this->title,
                        'body' => $this->pesan,
                    ],
                    'data' => [
                        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
                        'type' => $this->type,
                    ]
                ]
            ];

            $response = Http::withToken($accessToken)->post($url, $message);

            if ($response->failed()) {
                Log::error('FCM HTTP v1 gagal', [
                    'error' => $response->body(),
                    'user_id' => $notifiable->id,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim FCM dari StatusNotification.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => $notifiable->id,
            ]);
        }
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'body' => $this->pesan,
            'type' => $this->type,
        ];
    }
}
