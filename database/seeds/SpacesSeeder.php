<?php

use Illuminate\Database\Seeder;
use App\{User, Space};

class SpacesSeeder extends Seeder
{
    public function run()
    {
        $space = new Space([
            'name' => 'Pipers',
            'description' => 'A team of web technology enthusiasts.'
        ]);

        // Test user is id 2
        $testUser = User::find(2);
        $testUser->spaces()->save($space);
    }
}
