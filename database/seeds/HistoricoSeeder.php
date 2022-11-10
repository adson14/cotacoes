<?php

use Illuminate\Database\Seeder;

class HistoricoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            [
                'simbolo' => 'org1',
                'organizacao' => 'Org 1',
                'ultimo_preco' => '134',
                'volume' => '-',
                'moeda' => 'USD',
                'abertura' => '-',
                'fechamento' => '-',
            ],
            [
                'simbolo' => 'org2',
                'organizacao' => 'Org 2',
                'ultimo_preco' => '100',
                'volume' => '-',
                'moeda' => 'USD',
                'abertura' => '-',
                'fechamento' => '-',
            ],
            [
                'simbolo' => 'org3',
                'organizacao' => 'Org 3',
                'ultimo_preco' => '87',
                'volume' => '-',
                'moeda' => 'USD',
                'abertura' => '-',
                'fechamento' => '-',
            ],
        ];

        \App\Models\Historico::query()->insert($roles);
    }
}
