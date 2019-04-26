<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Models\Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        'project_id' => function () {
            return factory('App\Models\Project')->create()->id;
        }
    ];
});
