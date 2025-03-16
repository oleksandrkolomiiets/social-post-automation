<?php

namespace App\Repositories\Contracts;

use App\Models\Partner;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function createMany($data): bool;

    public function getByPartner(Partner $partner): LengthAwarePaginator;
}
