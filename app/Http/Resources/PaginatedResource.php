<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginatedResource
{
    /**
     * Format paginated response for mobile-friendly API.
     *
     * @param LengthAwarePaginator $paginator
     * @param string $resourceClass
     * @return array<string, mixed>
     */
    public static function format(LengthAwarePaginator $paginator, string $resourceClass): array
    {
        return [
            'data' => $resourceClass::collection($paginator->items()),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'last_page'    => $paginator->lastPage(),
            ],
        ];
    }
}
