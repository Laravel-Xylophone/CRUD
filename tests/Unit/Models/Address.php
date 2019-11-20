<?php

namespace Xylophone\CRUD\Tests\Unit\Models;

use Xylophone\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use CrudTrait;

    protected $table = 'addresses';
    protected $fillable = ['city', 'street', 'number'];

    /**
     * Get the author for the article.
     */
    public function accountDetails()
    {
        return $this->belongsTo('Xylophone\CRUD\Tests\Unit\Models\AccountDetails');
    }
}
