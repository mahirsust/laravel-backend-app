<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

#[Signature('app:send-task-reminder')]
#[Description('Command description')]
class SendTaskReminder extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('SendTaskReminder command executed successfully at ' . now());
    }
}
