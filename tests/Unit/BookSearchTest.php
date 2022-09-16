<?php

namespace Tests\Unit;

use App\Services\BookSearchService;
use Tests\TestCase;

class BookSearchTest extends TestCase
{
    public function test_get_book_list_without_filter()
    {
        $res = (new BookSearchService())->search();
        $this->assertNotEmpty($res);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('success', $res);
    }

    public function test_get_book_list_with_filter()
    {
        $res = (new BookSearchService())->search(fake()->asciify('********************'));
        $this->assertNotEmpty($res);
        $this->assertIsArray($res);
        $this->assertArrayHasKey('success', $res);
        $this->assertArrayHasKey('data', $res);
    }

}
