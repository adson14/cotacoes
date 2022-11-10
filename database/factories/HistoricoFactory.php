<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Historico;
use Faker\Generator as Faker;

$factory->define(Historico::class, function (Faker $faker) {
    return [
        'simbolo' => 'FBI',
        'organizacao' => 'FBI Invest',
        'ultimo_preco' => $faker->randomNumber(3),
        'volume' => 0,
        'moeda' => 'USD',
        'abertura' => 0,
        'fechamento' => 0,
    ];
});
