<?php

namespace App\Events;

use App\Models\Partner;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PartnerCreated
{
    use Dispatchable, SerializesModels;

    public function __construct(public Partner $partner)
    {
        //
    }
}
