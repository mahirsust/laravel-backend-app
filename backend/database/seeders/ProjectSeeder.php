<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 100000; $i++) {
            $data[] = [
                'name' => "Project $i",
                'description' => "Description for Project $i",
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($i % 10000 === 0) {
                DB::table('projects')->insert($data);
                $data = [];
            }
        }

        if (!empty($data)) {
            DB::table('projects')->insert($data);
        }
    }
}
