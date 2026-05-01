<?php

use App\Http\Controllers\RedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/r/{code}', RedirectController::class);
Route::get('/', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'backend',
    ]);
});
