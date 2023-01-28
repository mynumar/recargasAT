<?php

namespace Database\Seeders;

use App\Models\Motivo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Motivo::create(['descripcion' => 'Error de caja', 'estado' => 1]);
        Motivo::create(['descripcion' => 'Vaucher ilegible', 'estado' => 1]);
        Motivo::create(['descripcion' => 'Dato incorrecto', 'estado' => 1]);
        Motivo::create(['descripcion' => 'Número de cuenta incorrecta', 'estado' => 1]);
    }
}
