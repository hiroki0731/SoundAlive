<?php

namespace App\Mail;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPasswordReset extends Notification
{
    public $token;

    /**
     * SendPasswordReset constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('パスワード再設定')
            ->view('emails.password_reset')
            ->action('再設定', url('/password/reset', $this->token));
    }
}
