<?php

namespace App\Listeners;

use App\Events\NotifGenerated;
use App\Notifications\StatusNotification;

class SendStatusNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotifGenerated $event): void
    {
        $user = $event->user;
        if (!$user->fcm_token) {
            return;
        }

        $user->notify(new StatusNotification($event->title, $event->message, $event->type));
    }
}
