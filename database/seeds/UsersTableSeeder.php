<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'first_name'     => 'Kyouma',
                'last_name'      => 'Hououin',
                'contact_number' => '09673700022',
                'address'        => 'Area 51',
                'email'          => 'qatarafamilyresort.69@gmail.com',
                'password'       => '$2y$10$soCMjYlnUu2gV9qM1nD6D.bSjZVazYzsREbhNg0RAZIGIgGBU7vz.',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
