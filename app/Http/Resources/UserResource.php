<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object",
 *     title="User Resource",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@example.com"),
 *     @OA\Property(property="age", type="integer", example=25),
 *     @OA\Property(
 *         property="location",
 *         type="object",
 *         @OA\Property(property="city", type="string", example="Jakarta"),
 *         @OA\Property(property="country", type="string", example="Indonesia"),
 *         @OA\Property(property="latitude", type="number", format="float", example=-6.2088),
 *         @OA\Property(property="longitude", type="number", format="float", example=106.8456),
 *     ),
 *     @OA\Property(
 *         property="pictures",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PictureResource")
 *     )
 * )
 */
class UserResource extends JsonResource
{
    /**
     * Transform the user resource into a structured array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'email'     => $this->email,
            'age'       => $this->age,
            'location'  => [
                'city'    => $this->city,
                'country' => $this->country,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'pictures'  => PictureResource::collection($this->whenLoaded('pictures')),
        ];
    }
}
