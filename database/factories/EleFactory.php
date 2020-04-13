<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Election;
use App\Candidate;
use Faker\Generator as Faker;
// データを作るために、モデルを使う
$factory->define(Election::class, function (Faker $faker) {
    return [
        // electionsのuser_idに入れるidを作る
        'user_id' => factory('App\User')->make()->id,
        'title' => $faker->sentence,
        'subtitle' =>  $faker->paragraph,
        // 'name0' => factory('App\Candidate')->create()->name0,
    ];
  
            // getと同じか？ withと同じ リレーションで取ってくる
            // User::find(17)->load('elections');
});
