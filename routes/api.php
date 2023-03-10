<?php

use App\Domains\Order\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['as' => 'order.', 'prefix' => 'order'], function () {
    Route::post('/delay', [OrderController::class, 'delay'])
    ->name('delay');
});
