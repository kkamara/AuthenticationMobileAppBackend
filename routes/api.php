<?php

use Illuminate\Auth\Events\Verified;
use App\Http\Controllers\Mobile\V1\MobileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mobile\V1\UserController;
use App\Models\V1\User\User;
use \App\Http\Controllers\API\HealthController;
use App\Http\Controllers\API\EmailController;

// Add mobile app API routes
Route::prefix("/mobile/v1")->group(function () {
    Route::prefix("/user")->group(function () {
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
        Route::get('/email/verify', function () {
            return [
                "message" => "An email verification link has been sent to your email address. Please check your email and click on the link to verify your email address.",
            ];
        })->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', function (Request $request) {
            $user = User::query()->findOrFail($request->route('id'));

            if (! hash_equals(sha1($user->getEmailForVerification()), (string) $request->route('hash'))) {
                abort(403);
            }

            if (! $user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();

                event(new Verified($user));
            }
        
            return view("user.email-verified");
        })->middleware(['signed'])->name('verification.verify');
        Route::post('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
        
            return [
                'message' => 'Verification link sent!',
            ];
        })->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
    });
    Route::get("/hello", [
        MobileController::class,
        "hello",
    ]);
});

Route::get("/health", [
    HealthController::class,
    "health",
]);
Route::get("/email", [
    EmailController::class,
    "sendEmail",
]);
