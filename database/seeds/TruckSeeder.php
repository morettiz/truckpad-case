<?php

use App\Model\Truck;
use Illuminate\Database\Seeder;

class TruckSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Truck::insert([
            ['type' => 'Caminhão 3/4', 'code' => '1'],
            ['type' => 'Caminhão Toco', 'code' => '2'],
            ['type' => 'Camihão Truck', 'code' => '3'],
            ['type' => 'Carreta Simples', 'code' => '4'],
            ['type' => 'Carreta Eixo Extendido', 'code' => '5'],
        ]);
    }
}
