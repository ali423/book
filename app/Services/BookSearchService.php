<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class BookSearchService
{
    public function search(string $keyword = null)
    {
        try {
            $cachedBooks = Redis::get('search_books_' . $keyword);
            if (!empty($cachedBooks)) {
                $data = json_decode($cachedBooks, true);
            } else {
                $response = Http::asForm()->post('https://search.fidibo.com', [
                    'q' => $keyword,
                ])->json();
                $data = $response['books']['hits']['hits'];
                Redis::set('search_books_' . $keyword, json_encode($data), 'EX', 600);
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
