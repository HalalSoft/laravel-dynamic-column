<?php

namespace Halalsoft\LaravelDynamicColumn\Tests;

use Halalsoft\LaravelDynamicColumn\Tests\Models\Page;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as BaseTestCase;

class  TestCase extends BaseTestCase
{
    public static $setupDatabase = true;

    protected function setUp(): void
    {
        parent::setUp();

        if (self::$setupDatabase) {
            $this->setUpDatabase();
        }
    }

    protected function setUpDatabase()
    {
        Schema::dropIfExists('pages');
        Schema::create(
            'pages',
            function($table) {
                $table->increments('id');
                $table->string('title');
                $table->text('content');
                $table->binary('options')->nullable();
                $table->timestamps();
            }
        );


        DB::select(
            "INSERT INTO pages VALUES (1,'Page with dynamic column','This is page with dynamic column', COLUMN_CREATE('author', 'Dyas', 'email', 'dyas@yaskur.com') , NULL, NULL)"
        );

        Page::create(
            [
                'title'   => "Page title 1",
                'content' => 'This is page content 1',
                'options' => ['author' => 'Yaskur', 'reference' => 'http://yaskur.net'],
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
                'host'     => '34.121.57.251',
                'port'     => '3306',
                'database' => 'testdb',
                'username' => 'root',
                'password' => '',
            ]
        );
    }
}