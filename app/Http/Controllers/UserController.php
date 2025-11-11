<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLike;
use App\Http\Resources\UserResource;
use App\Http\Resources\PaginatedResource;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/recommendations",
     *     summary="Get recommended users",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of recommended users"
     *     )
     * )
     */
    public function recommendations(Request $request)
    {
        
        $perPage = $request->query('per_page', 10);
        $page    = $request->query('page', 1);

        $authUserId = $request->user()->id;

        $excludedIds = UserLike::where('liker_id', $authUserId)
            ->pluck('liked_id')
            ->toArray();

        $users = User::with('pictures')
            ->whereNotIn('id', $excludedIds)
            ->inRandomOrder()
            ->paginate($perPage, ['*'], 'page', $page);

        return PaginatedResource::format($users, UserResource::class);
    }

    /**
     * @OA\Post(
     *     path="/api/users/{user}/like",
     *     summary="Like a user",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User liked successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Cannot like yourself"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Target user not found"
     *     )
     * )
     */
    public function like(Request $request, User $user)
    {
        $liker = $request->user();

        if (!$liker) {
            return JsonResponse::error('Unauthenticated', 401);
        }

        if (!$user || !$user->exists) {
            return JsonResponse::error('Target user not found', 404);
        }

        if ($liker->id === $user->id) {
            return JsonResponse::error('Cannot like yourself', 400);
        }

        UserLike::updateOrCreate(
            ['liker_id' => $liker->id, 'liked_id' => $user->id],
            ['is_liked' => true, 'created_at' => now()]
        );

        return JsonResponse::success('Liked', [
            'liker_id' => $liker->id,
            'liked_id' => $user->id,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/users/{user}/dislike",
     *     summary="Dislike a user",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User disliked successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Cannot dislike yourself"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Target user not found"
     *     )
     * )
     */
    public function dislike(Request $request, User $user)
    {
        $liker = $request->user();

        if (!$liker) {
            return JsonResponse::error('Unauthenticated', 401);
        }

        if (!$user || !$user->exists) {
            return JsonResponse::error('Target user not found', 404);
        }

        if ($liker->id === $user->id) {
            return JsonResponse::error('Cannot dislike yourself', 400);
        }

        UserLike::updateOrCreate(
            ['liker_id' => $liker->id, 'liked_id' => $user->id],
            ['is_liked' => false, 'created_at' => now()]
        );

        return JsonResponse::success('Disliked', [
            'liker_id' => $liker->id,
            'disliked_id' => $user->id,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/users/liked",
     *     summary="Get list of liked users",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of users liked by the authenticated user"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function liked(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return JsonResponse::error('Unauthenticated', 401);
        }

        $likedUsers = $user->likesGiven()
            ->where('is_liked', true)
            ->with('liked.pictures')
            ->get()
            ->pluck('liked');

        return JsonResponse::success('Liked users retrieved', [
            'count' => $likedUsers->count(),
            'users' => UserResource::collection($likedUsers),
        ]);
    }
}
