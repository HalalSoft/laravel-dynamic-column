<?php

namespace Halalsoft\LaravelDynamicColumn\Tests\Models;

use Halalsoft\LaravelDynamicColumn\Dynamic;
use Halalsoft\LaravelDynamicColumn\DynamicObject;
use Halalsoft\LaravelDynamicColumn\HasDynamicColumn;
use Illuminate\Database\Eloquent\Model;

class PageObj extends Model
{
    use HasDynamicColumn;

    protected $guarded = [];
    protected $table = 'pages';
    protected $casts
        = [
            'options' => DynamicObject::class,
        ];


}
