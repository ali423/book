<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchBookRequest;
use App\Http\Resources\BookSearchResource;
use App\Services\BookSearchService;

class BookController extends Controller
{
    protected $service;

    public function __construct(BookSearchService $book_search_service)
    {
        $this->service = $book_search_service;
    }

    public function search(SearchBookRequest $request)
    {
        $keyword = $request->get('keyword');
        $res = $this->service->search($keyword);
        if (isset($res['success']) && $res['success'] == false) {
            return $this->responseError($res['errors']);
        }
        return BookSearchResource::collection($res['data']);
    }
}
