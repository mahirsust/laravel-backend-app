<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTasks;

class QueueController extends Controller
{
    public function withoutQueue()
    {
        $start = microtime(true);

        sleep(5);

        return response()->json([
            'type' => 'without queue',
            'time' => microtime(true) - $start,
        ]);
    }

    public function withQueue()
    {
        $start = microtime(true);

        dispatch(new ProcessTasks());

        return response()->json([
            'type' => 'with queue',
            'time' => microtime(true) - $start,
        ]);
    }
}
