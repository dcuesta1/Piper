<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(SpacesSeeder::class);
        $this->call(ProjectsSeeder::class);
    }
}
