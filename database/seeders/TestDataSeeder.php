<?php

namespace Database\Seeders;

use App\Models\GameItem;
use App\Models\Skin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $user = User::create([
            'email' => 'test@gmail.com',
            'password' => Hash::make(12341234),
            'name' => 'Test',
        ]);
        $user->assignRole(User::ROLE_OWNER);
        $user->removeRole(User::ROLE_BASIC);

        $gameItem_1 = GameItem::create([
            'title' => 'AK-47',
            'description' => 'Штурмовая винтовка',
        ]);

        $gameItem_2 = GameItem::create([
            'title' => 'M16',
            'description' => 'Штурмовая винтовка',
        ]);

        $gameItem_3 = GameItem::create([
            'title' => 'Desert Eagle',
            'description' => 'Пистолет',
        ]);

        foreach (range(1, 50) as $number) {
            Skin::create([
                'game_item_id' => $gameItem_1->id,
                'description' => $faker->sentence,
                'pattern' => $number,
                'float' => $faker->randomFloat(random_int(1, 6), 0, 1),
            ]);
        }
    }
}
