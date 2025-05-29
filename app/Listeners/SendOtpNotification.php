<?php

namespace App\Listeners;

use App\Events\OtpGenerated;
use App\Notifications\OtpCodeNotification;

class SendOtpNotification
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
    public function handle(OtpGenerated $event): void
    {
        $event->user->notify(new OtpCodeNotification($event->otp));
    }
}
