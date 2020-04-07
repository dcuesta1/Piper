<?php

use App\{Project, User};
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        $project = new Project([
            'creator_id' => 2,
            'name' => 'Piper',
            'description' => 'A ticket tracker program for software development projects.',
            'repository_url' => 'https://github.com/dcuesta1/Piper'
        ]);

        $space = App\Space::find(1);
        $space->projects()->save($project);
    }
}
