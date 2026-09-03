<?php

namespace App\Http\Controllers\Mobile\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Mail\UserRegistrationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\V1\User;

class EmailController extends Controller
{
    public function sendUserRegistrationEmail(): JsonResponse {
        $user = User::inRandomOrder()->first();

        Mail::to([
            "bar@example.com",
            "baz@example.com",
        ])->send(new UserRegistrationMail($user));

        return response()->json([
            "message" => "Message sent.",
        ]);
    }
}
