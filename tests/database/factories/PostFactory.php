<?php

use Sarala\Dummy\Post;
use Sarala\Dummy\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentences(1, true),
        'subtitle' => $faker->sentences(2, true),
        'body' => $faker->paragraphs(3, true),
        'published_at' => $faker->boolean ? $faker->dateTimeBetween('-1 months', '+1 months') : null,
        'author_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
