<?php

use App\Http\Controllers\Mobile\V1\MobileController;
use App\Http\Controllers\Mobile\V1\EmailController as MobileEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserController;
use \App\Http\Controllers\API\HealthController;
use App\Http\Controllers\API\EmailController;

// Add mobile app API routes
Route::prefix("/mobile/v1")->group(function () {
    Route::get("/hello", [
        MobileController::class,
        "hello",
    ]);
    Route::get("/email", [
        MobileEmailController::class,
        "sendUserRegistrationEmail",
    ])->name("sendUserRegistrationEmail");
});
// Add third-party API routes
Route::prefix("/v1/user")->group(function () {
    Route::post("/register", [UserController::class, "register"]);
    Route::post("/", [UserController::class, "login"]);
    Route::delete(
        "/",
        [UserController::class, "logout"],
    )->middleware("auth:sanctum");
    Route::get(
        "/authorise",
        [UserController::class, "authorizeUser"],
    )->middleware("auth:sanctum");
});

Route::get("/health", [
    HealthController::class,
    "health",
]);
Route::get("/email", [
    EmailController::class,
    "sendEmail",
]);
