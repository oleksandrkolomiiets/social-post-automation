<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function __construct(Post $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->resource->uuid,
            'title' => $this->resource->title,
            'headline' => $this->resource->headline,
            'message' => $this->resource->message,
            'link' => $this->resource->link,
        ];
    }
}
