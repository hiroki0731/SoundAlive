<?php

use Faker\Generator as Faker;
use App\Http\Models\Concert;

$factory->define(Concert::class, function (Faker $faker) {
    return [
        'user_id' => $faker->sentence(rand(1, 4)), // 1〜4つの単語で文章
        'detail_info' => $faker->realText(512), // 512文字の文章
    ];
});
