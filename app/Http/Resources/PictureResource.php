<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PictureResource",
 *     type="object",
 *     title="Picture Resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="url", type="string", example="https://example.com/image.jpg"),
 *     @OA\Property(property="is_primary", type="boolean", example=true)
 * )
 */
class PictureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'url'        => $this->url,
            'is_primary' => (bool) $this->is_primary,
        ];
    }
}
