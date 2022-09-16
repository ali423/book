<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BookSearchService
{
    public function search(string $keyword = null)
    {
        try {
            $cachedBooks = Cache::get('search_books_' . $keyword);
            if (!empty($cachedBooks)) {
                $data = json_decode($cachedBooks, true);
            } else {
                $response = Http::asForm()->post('https://search.fidibo.com', [
                    'q' => $keyword,
                ])->json();
                $data = $response['books']['hits']['hits'];
                Cache::put('search_books_' . $keyword, json_encode($data), config('setup.book_search.cache_seconds'));
            }
            return [
                'data' => $data,
                'success' => true,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => [
                    'مشکلی وجود دارد ، لطفا بعدا امتحان کنید .'
                ]
            ];
        }
    }
}
