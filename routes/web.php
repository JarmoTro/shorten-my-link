<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\URLController;

Route::get('/', function () {
    return view('home');
});

Route::post('/URLs', [URLController::class, "createURL"]);

Route::get('/URLs/{shortURL}', [URLController::class, "getSingleURL"]);
