<?php

use App\Models\Contents\Video;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Video::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6, true),
        'description' => $faker->realText(mt_rand(10, 20)),
        'count_likes' => $faker->numberBetween(0, 100),
        'count_dislikes' => $faker->numberBetween(0, 100),
    ];
});
