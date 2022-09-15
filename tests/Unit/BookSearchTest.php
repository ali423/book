<?php

namespace Tests\Unit;

use App\Services\BookSearchService;
use Illuminate\Support\Facades\Redis;
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

    public function test_get_book_list_from_cache()
    {
        $fake_data = [
            fake()->name,
        ];
        $keyword = 'test';
        Redis::set('search_books_' . $keyword, json_encode($fake_data), 'EX', config('setup.book_search.cache_seconds'));
        $res = (new BookSearchService())->search($keyword);
        $this->assertArrayHasKey('data', $res);
        $this->assertNotEmpty($res['data']);
        $this->assertEquals($fake_data, $res['data']);
    }

}
