<?php

namespace App\Repositories;

use App\Models\Partner;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository implements PostRepositoryInterface
{
    public function __construct(protected Post $model)
    {
        //
    }

    public function createMany($data): bool
    {
        return $this->model->query()->insert($data);
    }

    public function getByPartner(Partner $partner): LengthAwarePaginator
    {
        return $partner->posts()->paginate(3);
    }
}
