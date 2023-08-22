<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Project::factory()->create(
            [
                'owner_id' => 1,
                'project_name' => 'First Project Name',
                'project_description' => 'First Project Description'
            ]
        );

        \App\Models\Project::factory()->create(
            [
                'owner_id' => 1,
                'project_name' => 'This is a second project',
                'project_description' => 'Second Project Description'
            ]
        );
    }
}
