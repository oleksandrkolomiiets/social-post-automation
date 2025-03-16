<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Partner;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;

class PartnerController extends Controller
{
    public function __construct(protected PostRepositoryInterface $postRepository)
    {
        //
    }

    public function posts(Partner $partner): JsonResponse
    {
        return response()->json(
            PostResource::collection($this->postRepository->getByPartner($partner)),
        );
    }
}
