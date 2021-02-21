<?php

namespace Halalsoft\LaravelDynamicColumn\Tests;


use Halalsoft\LaravelDynamicColumn\Tests\Models\Page;
use Halalsoft\LaravelDynamicColumn\Tests\Models\PageObj;

class PageModelTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }


//    /** @test */
//    public function it_tests_right_row_count()
//    {
//        $pages = Page::get();
//
//        $this->assertCount(3, $pages);
//    }
    /** @test */
    public function it_tests_right_rsow_count()
    {
        $pages = PageObj::first();
        $this->assertCount(3, $pages);
    }

//    /** @test */
//    public function it_tests_get_dynamic_column_data()
//    {
//        $page = Page::find(1);
//
//        $this->assertIsArray($page->options);
//    }
//
//
//    /** @test */
//    public function it_tests_create_dynamic_column_data()
//    {
//        $page = Page::create(
//            [
//                'title'   => "Another title dynamic column",
//                'content' => 'This is another page content ',
//                'options' => ['author' => 'Anonimous', 'reference' => 'http://anonymous.org'],
//            ]
//        );
//
//        $this->assertIsArray($page->options);
//        $this->assertEquals('Another title dynamic column', $page->title);
//    }
//
//    /** @test */
//    public function it_tests_create_dynamic_column_data_using_eloquent()
//    {
//        $page          = new Page();
//        $page->title   = "Another page using eloquent";
//        $page->content = "This is another page using eloquent";
//        $page->options = ['author' => 'secret author'];
//        $page->save();
//
//        $this->assertIsArray($page->options);
//        $this->assertEquals('Another page using eloquent', $page->title);
//    }
//
//    /** @test */
//    public function it_tests_update_dynamic_column_data()
//    {
//        $page = Page::find(1);
//
//        $page->update(['options->reference' => 'http://yaskur.com']);
//
//        $this->assertIsArray($page->options);
//        $this->assertEquals('http://yaskur.com', $page->options['reference']);
//        $this->assertEquals('Dyas', $page->options['author']);
//        $this->assertEquals('dyas@yaskur.com', $page->options['email']);
//    }
//
//    /** @test */
//    public function it_tests_update_dynamic_column_data_using_eloquent()
//    {
//        $page                 = Page::find(1);
//        $options              = $page->options;
//        $options['reference'] = 'https://yaskur.com';
//        $page->options        = $options;
//        $page->save();
//
//        $this->assertIsArray($page->options);
//        $this->assertEquals('https://yaskur.com', $page->options['reference']);
//        $this->assertEquals('Dyas', $page->options['author']);
//        $this->assertEquals('dyas@yaskur.com', $page->options['email']);
//    }


}