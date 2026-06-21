<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    public function slow()
    {
        $startTime = microtime(true);

        $projects = DB::table('projects')
            ->where('status', 'active')
            ->limit(100000)
            ->get()
            ->toArray();

        $executionTime = (microtime(true) - $startTime) * 1000;

        return response()->json([
            'source' => 'database',
            'time'   => round($executionTime, 2) . ' ms',
            'count'  => count($projects),
        ]);
    }

    public function fast()
    {
        $startTime = microtime(true);

        $source = Cache::has('projects.cache') ? 'cache' : 'database';

        $projects = Cache::remember('projects.cache', 60, function () {
            return DB::table('projects')
                ->where('status', 'active')
                ->limit(100000)
                ->get()
                ->toArray();
        });

        $executionTime = (microtime(true) - $startTime) * 1000;

        return response()->json([
            'source' => $source,
            'time'   => round($executionTime, 2) . ' ms',
            'count'  => count($projects),
        ]);
    }
}
