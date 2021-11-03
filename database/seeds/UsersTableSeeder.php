<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\RoleUser;

class UsersTableSeeder extends Seeder
{
    public function run()
    {

        $admin = User::create([
            'first_name'     => 'Kyouma',
            'last_name'      => 'Hououin',
            'contact_number' => '09673700020',
            'address'        => 'Area 51',
            'email'          => 'qatarafamilyresort.69@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password'       => bcrypt('password'),
            'remember_token' => null,
        ]);

        $client = User::create([
            'first_name'     => 'John',
            'last_name'      => 'Doe',
            'contact_number' => '09123456789',
            'address'        => 'Tokyo, Japan',
            'email'          => 'hououinkyouma.000001@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password'       => bcrypt('asdasdasd'),
            'remember_token' => null,
        ]);

        RoleUser::create([
            'user_id' => $client->id,
            'role_id' => 3
        ]);

        
    }
}
