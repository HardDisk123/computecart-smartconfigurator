<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;   // <-- import Mail facade
use App\Mail\WelcomeUserMail;          // <-- import your mailable

class SendWelcomeEmail
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
    public function handle(Registered $event): void
    {
        // Send the welcome email to the newly registered user
        Mail::to($event->user->email)->send(new WelcomeUserMail($event->user));
    }
}
