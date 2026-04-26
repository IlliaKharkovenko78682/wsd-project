<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::query()->delete();

        Task::query()->create([
            'title' => 'Seeded task A',
            'description' => 'Deterministic example A',
            'status' => 'todo',
            'priority' => 'low',
        ]);

        Task::query()->create([
            'title' => 'Seeded task B',
            'description' => 'Deterministic example B',
            'status' => 'doing',
            'priority' => 'medium',
        ]);

        Task::query()->create([
            'title' => 'Seeded task C',
            'description' => 'Deterministic example C',
            'status' => 'done',
            'priority' => 'high',
        ]);
    }
}