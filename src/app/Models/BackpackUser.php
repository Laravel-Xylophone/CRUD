<?php

namespace Xylophone\CRUD\app\Models;

use App\User;
use Xylophone\CRUD\app\Models\Traits\InheritsRelationsFromParentModel;
use Xylophone\CRUD\app\Notifications\ResetPasswordNotification as ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;

class XylophoneUser extends User
{
    use InheritsRelationsFromParentModel;
    use Notifiable;

    protected $table = 'users';

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }
}
