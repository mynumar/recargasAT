<?php

namespace Database\Seeders;

use App\Models\Banco;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Banco::create(['descripcion' => 'BBVA', 'ncuenta' => '1234567890', 'estado' => 1]);
        Banco::create(['descripcion' => 'BCP', 'ncuenta' => '0987654321', 'estado' => 1]);
        Banco::create(['descripcion' => 'Interbank', 'ncuenta' => '5432167890', 'estado' => 1]);
        Banco::create(['descripcion' => 'Scotianbank', 'ncuenta' => '1234509876', 'estado' => 1]);
        Banco::create(['descripcion' => 'yape', 'ncuenta' => '987654321', 'estado' => 1]);
        Banco::create(['descripcion' => 'plin', 'ncuenta' => '987654321', 'estado' => 1]);
    }
}
