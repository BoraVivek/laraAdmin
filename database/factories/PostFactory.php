<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id'       =>  1,
        'category_id'   =>  1,
        'title'         =>  $faker->sentence,
        'slug'          =>  $faker->slug,
        'image'         =>  $faker->imageUrl(),
        'content'       =>  $faker->text,
        'meta_title'    =>  $faker->sentence,
        'meta_description'  =>  $faker->paragraph,
    ];
});
