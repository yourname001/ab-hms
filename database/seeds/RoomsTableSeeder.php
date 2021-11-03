<?php

use App\Models\RoomType;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 5; $i++) { 
            $roomType = RoomType::inRandomOrder()->first();
            Room::create([
                'image' => "room-" . $i . ".jpg",
                'featured' => 1,
                'capacity' => 1 + $i,
                'amount' => 500 * $i,
                'name' => "Room #" . $i . ' - ' . $roomType->name,
                'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nascetur ridiculus mus mauris vitae ultricies leo integer. Pellentesque id nibh tortor id. Scelerisque varius morbi enim nunc faucibus a pellentesque. Id velit ut tortor pretium viverra. Sit amet mattis vulputate enim nulla aliquet. Dui accumsan sit amet nulla facilisi morbi tempus. Tellus cras adipiscing enim eu turpis. At imperdiet dui accumsan sit amet nulla facilisi. Arcu bibendum at varius vel pharetra vel turpis. Purus in mollis nunc sed. Varius sit amet mattis vulputate enim.",
                'room_type_id' => $roomType->id
            ]);
        }
    }
}
