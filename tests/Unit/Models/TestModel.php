<?php

namespace Xylophone\CRUD\Tests\Unit\Models;

use Xylophone\CRUD\app\Models\Traits\CrudTrait;

class TestModel extends \Illuminate\Database\Eloquent\Model
{
    use CrudTrait;
}
