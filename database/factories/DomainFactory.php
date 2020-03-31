<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Domain;
use Faker\Generator as Faker;

$factory->define(Domain::class, function (Faker $faker) {
    return [
        'name' => $faker->url,
    ];
});