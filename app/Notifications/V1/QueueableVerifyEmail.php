<?php

namespace App\Notifications\V1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;

class QueueableVerifyEmail extends VerifyEmail implements ShouldQueue
{
    use Queueable;
}
