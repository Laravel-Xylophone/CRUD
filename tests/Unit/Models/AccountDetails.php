<?php

namespace Xylophone\CRUD\Tests\Unit\Models;

use Xylophone\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class AccountDetails extends Model
{
    use CrudTrait;

    protected $table = 'account_details';
    protected $fillable = ['user_id', 'nickname', 'profile_picture'];

    /**
     * Get the user for the account details.
     */
    public function user()
    {
        return $this->belongsTo('Xylophone\CRUD\Tests\Unit\Models\User');
    }

    public function addresses()
    {
        return $this->hasMany('Xylophone\CRUD\Tests\Unit\Models\Address');
    }
}
