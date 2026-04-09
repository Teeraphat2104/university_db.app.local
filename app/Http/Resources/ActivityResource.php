<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'description'      => $this->description,
            'cover_image_url'  => $this->cover_image_url,
            'pdf_url'          => $this->pdf_url,
            'category'         => $this->whenLoaded('category', fn () => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
            ]),
            'category_id'      => $this->category_id,
            'activity_date'    => $this->activity_date?->format('Y-m-d'),
            'location'         => $this->location,
            'status'           => (int) $this->status,
            'created_at'       => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
