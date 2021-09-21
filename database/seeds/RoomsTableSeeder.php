<?php

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
/*         $room_types = RoomType::all();
        $roomTypes = RoomType::pluck('id');

        foreach($room_types as $room_type)
        {
            for($i = 1; $i <= mt_rand(100,500); $i++)
            {
                $room_type->roomTypeRooms()->create([
                    'name' => mt_rand(100,999),
                    'room_type_id' => $roomTypes->random()
                ]);
            }
        } */
    }
}
