<?php

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::insert([
            ['name' => 'Superior Name'],
            ['name' => 'Deluxe Room'],
            ['name' => 'Couple Room'],
            ['name' => 'Signature Room']
        ]);
    }
}
