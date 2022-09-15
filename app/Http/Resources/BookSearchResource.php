<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'image_name' => $this['_source']['image_name'],
            'publishers' => $this['_source']['publishers'],
            'id' => $this['_source']['id'],
            'title' => $this['_source']['title'],
            'content' => $this['_source']['content'],
            'slug' => $this['_source']['slug'],
            'authors' => BookAuthorResource::collection($this['_source']['authors']),
        ];
    }
}
