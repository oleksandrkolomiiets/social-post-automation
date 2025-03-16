<?php

namespace App\Events;

use App\Models\PostTemplate;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostTemplateCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public PostTemplate $postTemplate)
    {
        //
    }
}
