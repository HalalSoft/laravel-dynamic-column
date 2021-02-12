<?php

namespace Halalsoft\LaravelDynamicColumn\Tests;


use Halalsoft\LaravelDynamicColumn\Tests\Models\Page;

class PageModelTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_tests_right_row_count()
    {
        $pages = Page::all();

        $this->assertCount(3, $pages);
    }

    /** @test */
    public function it_tests_get_dynamic_column_data()
    {
        $page = Page::find(1);

        $this->assertIsArray($page->options);
    }

    /** @test */
    public function it_tests_create_data()
    {
        $pages = Page::create(
            [
                'title'   => "Another title dynamic column",
                'content' => 'This is another page content ',
                'options' => ['author' => 'Anonimous', 'okay'],
            ]
        );

        $this->assertCount(4, $pages);
    }

}