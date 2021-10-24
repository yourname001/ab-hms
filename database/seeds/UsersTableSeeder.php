<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
                'email_verified_at' => Carbon::now(),
                'password'       => '$2y$10$soCMjYlnUu2gV9qM1nD6D.bSjZVazYzsREbhNg0RAZIGIgGBU7vz.',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
    }
}
