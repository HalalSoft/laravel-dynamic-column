<?php

namespace Halalsoft\LaravelDynamicColumn\Tests;

use Halalsoft\LaravelDynamicColumn\Tests\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Orchestra\Testbench\TestCase as BaseTestCase;

class  TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    protected function setUpDatabase()
    {
        file_put_contents(__DIR__.'/temp/database.sqlite', null);


        $this->app['db']->connection()->getSchemaBuilder()->create(
            'pages',
            function(Blueprint $table) {
                $table->increments('id');
                $table->text('options')->nullable();
            }
        );
//        $this->createTables('articles', 'users');


        Page::create(['id' => 1]);
    }

    /**
     * @param  Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'mysql');
        $app['config']->set(
            'database.connections.mysql',
            [
                'driver'   => 'mysql',
                'host'     => '127.0.0.1',
                'port'     => '3306',
                'database' => 'testdb',
                'user'     => 'root',
            ]
        );
    }
}