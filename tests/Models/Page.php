<?php

namespace Halalsoft\LaravelDynamicColumn\Tests\Models;

use Halalsoft\LaravelDynamicColumn\Dynamic;
use Halalsoft\LaravelDynamicColumn\HasDynamicColumn;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasDynamicColumn;

    protected $guarded = [];

    public $timestamps = false;


//    protected $casts
//        = [
//            'options' => Dynamic::class,
//        ];


}
