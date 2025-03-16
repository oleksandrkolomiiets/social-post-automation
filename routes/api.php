<?php

use App\Http\Controllers\PartnerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json('Social Post Automation');
});

Route::group(['prefix' => 'partners', 'as' => 'partners.'], function () {
    Route::get('{partner:id}/posts', [PartnerController::class, 'posts']);
});
