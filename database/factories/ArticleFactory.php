<?php

use App\Models\Contents\Article;
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

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6, true),
        'content' => $faker->realText(mt_rand(10, 20)),
        'count_likes' => $faker->numberBetween(0, 100),
        'count_dislikes' => $faker->numberBetween(0, 100),
    ];
});
