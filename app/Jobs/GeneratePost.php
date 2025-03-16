<?php

namespace App\Jobs;

use App\Models\Partner;
use App\Models\PostTemplate;
use App\Services\PostService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;

class GeneratePost implements ShouldQueue
{
    use Dispatchable, Queueable;

    public function __construct(public Model $model)
    {
        //
    }

    /**
     * @throws \Exception
     */
    public function handle(PostService $service): void
    {
        switch (get_class($this->model)) {
            case Partner::class:
                $service->generateForPartner($this->model);

                break;
            case PostTemplate::class:
                $service->generateForPostTemplate($this->model);

                break;
            default:
                throw new \Exception('Unknown model type: ' . get_class($this->model));
        }
    }
}
