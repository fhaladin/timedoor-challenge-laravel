<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Post;

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
            Post::create([
                'name'  => $faker->firstName,
                'title' => $faker->text($maxNbChars = 32),
                'body' => $faker->text($maxNbChars = 200),
                'password' => 'password',
                'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'Asia/Jakarta')
            ]);
        }
    }
}
