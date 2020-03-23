<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 30; $i++) { 
            $rand_number = $faker->numberBetween($min = 1000, $max = 9999);
            Post::create([
                'name'  => $faker->firstName,
                'title' => $faker->text($maxNbChars = 32),
                'body' => $rand_number . ' - ' . $faker->text($maxNbChars = 190),
                'password' => bcrypt($rand_number),
                'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'Asia/Jakarta')
            ]);
        }
    }
}
