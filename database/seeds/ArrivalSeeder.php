<?php

use App\Model\Arrival;
use Illuminate\Database\Seeder;

class ArrivalSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Arrival::class, 1000)->create();
    }
}
