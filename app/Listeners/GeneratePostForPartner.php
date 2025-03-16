<?php

namespace App\Listeners;

use App\Events\PartnerCreated;
use App\Jobs\GeneratePost;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GeneratePostForPartner implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PartnerCreated $event): void
    {
        GeneratePost::dispatch($event->partner);
    }
}
