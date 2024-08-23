<?php

use Illuminate\Support\Facades\Schedule;

//not overlapping  with the web routes
Schedule::command('app:send-messages-command')->everyMinute()
    // ->appendOutputTo(storage_path('logs/send-messages-command.log'))
    ->withoutOverlapping();
