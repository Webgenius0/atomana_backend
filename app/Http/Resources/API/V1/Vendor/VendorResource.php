<?php

namespace App\Http\Resources\API\V1\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'business_id' => $this->business_id,
            'vendor_category_id' => $this->vendor_category_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'website' => $this->website,
            'email' => $this->email,
            'phone' => $this->phone,
            'about' => $this->about,
            'additional_note' => $this->additional_note,
            'reviews_count' => $this->reviews_count,
            'business' => [
                'id' => $this->business->id ?? null,
                'licence' => $this->business->licence ?? null,
                'ecar_id' => $this->business->ecar_id ?? null,
            ],
            'category' => [
                'id' => $this->category->id ?? null,
                'name' => $this->category->name ?? null,
                'slug' => $this->category->slug ?? null,
                'icon' => $this->category->icon ?? null,
            ],
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
        ];
    }
}
