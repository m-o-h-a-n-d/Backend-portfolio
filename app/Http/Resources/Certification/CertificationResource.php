<?php

namespace App\Http\Resources\Certification;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CertificationResource extends JsonResource
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
            'name' => $this->name,
            'image' => $this->image ? Storage::disk('s3')->url($this->image) : null,
            'text' => $this->text,
            'date' => $this->date?->toDateString(),
            'order' => $this->order,
        ];
    }
}
