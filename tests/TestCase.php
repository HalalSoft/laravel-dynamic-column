<?php

namespace Halalsoft\LaravelDynamicColumn\Tests;

use Halalsoft\LaravelDynamicColumn\Tests\Models\Page;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
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
        $this->app['db']->connection()->getSchemaBuilder()->create(
            'pages',
            function(Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->text('content');
                $table->binary('options')->nullable();
            }
        );

        DB::select(
            "INSERT INTO pages VALUES (1,'Page with dynamic column','This is page with dynamic column', COLUMN_CREATE('color', 'black', 'price', 500))"
        );

        Page::create(
            [
                'title'   => "Page title 1",
                'content' => 'This is page content 1',
            ]
        );
        Page::create(
            [
                'title'   => "Page title 2",
                'content' => 'This is page content 2',
            ]
        );
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
                'username' => 'root',
            ]
        );
    }
}