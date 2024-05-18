<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\URLController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});

Route::get('/faq', function () {
    return view('faq');
});

Route::get("/login", [AuthController::class, "getLoginRegisterPage"]);

Route::post("/login", [AuthController::class, "login"]);

Route::post("/register", [AuthController::class, "register"]);

Route::post('/URLs', [URLController::class, "createURL"]);

Route::get('/URLs/{shortURL}', [URLController::class, "getSingleURL"]);

Route::get('/my-links', [URLController::class, "getUserLinksPage"]);

Route::get('/{shortURL}', [URLController::class, "redirectToURL"]);
