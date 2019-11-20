<?php

namespace Xylophone\CRUD\app\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(trans('xylophone::base.password_reset.subject'))
            ->greeting(trans('xylophone::base.password_reset.greeting'))
            ->line([
                trans('xylophone::base.password_reset.line_1'),
                trans('xylophone::base.password_reset.line_2'),
            ])
            ->action(trans('xylophone::base.password_reset.button'), route('xylophone.auth.password.reset.token', $this->token).'?email='.urlencode($notifiable->getEmailForPasswordReset()))
            ->line(trans('xylophone::base.password_reset.notice'));
    }
}
