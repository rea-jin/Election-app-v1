<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Candidate;
use Faker\Generator as Faker;

$factory->define(Candidate::class, function (Faker $faker) {
    return [
        //
        'election_id' => factory('App\Election')->make()->id,
        // 'election_id' => $election->id,
        'name0' => $faker->sentence,
        'com0' => $faker->sentence
    ];
});
