<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $devUser = new User([
            'name' => 'Daniel Cuesta',
            'username' => 'dcuesta31',
            'email' => 'cuesta.daniel.ivan@gmail.com',
            'phone' => '13215773094',
            'password' => bcrypt('pass'),
            'type' => User::DEVELOPER_USER
        ]);

        $adminUser = new User([
            'name' => 'John Smith',
            'username' => 'jsmith',
            'email' => 'jsmith@mail.com',
            'phone' => '1321321322',
            'password' => bcrypt('pass'),
            'type' => User::COMPANY_ADMIN_USER
        ]);


        $devUser->save();
        $adminUser->save();
    }
}
