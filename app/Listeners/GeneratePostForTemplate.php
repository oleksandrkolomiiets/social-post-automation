<?php

namespace App\Listeners;

use App\Events\PostTemplateCreated;
use App\Jobs\GeneratePost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GeneratePostForTemplate implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PostTemplateCreated $event): void
    {
        GeneratePost::dispatch($event->postTemplate);
    }
}
