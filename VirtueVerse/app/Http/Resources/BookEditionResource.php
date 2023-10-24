<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookEditionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'pages' => $this->pages,
            'language' => $this->language,
            'isbn' => $this->isbn,
            'bookId' => $this->id,
            'editionsKey' => $this->editions_key, 
        ];    
    }
}