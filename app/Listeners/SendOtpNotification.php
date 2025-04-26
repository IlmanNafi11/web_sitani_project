<?php

namespace App\Listeners;

use App\Events\OtpGenerated;
use App\Notifications\OtpCodeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOtpNotification  implements ShouldQueue
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
