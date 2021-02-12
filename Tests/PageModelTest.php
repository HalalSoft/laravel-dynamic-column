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
    public function it_tests_something()
    {
        $pages = Page::all();

        $this->assertCount(1, $pages);
    }

}