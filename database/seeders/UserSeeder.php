<?php

namespace Database\Seeders;

use App\Models\Billetera;
use App\Models\Cliente;
use App\Models\Promotore;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user_dev = User::create([
            'name' => 'admin',
            'lastname' => 'admin',
            'email' => 'admin@recargas.com',
            'email_verified_at' => '2022-01-01 12:00:00',
            'password' => Hash::make('123@456')
        ]);

        $user_dev->assignRole('developer');

        $user_pro = User::create([
            'name' => 'Maria',
            'lastname' => 'Benites',
            'email' => 'maria@recargas.com',
            'email_verified_at' => '2022-01-01 12:00:00',
            'password' => Hash::make('123@456')
        ]);

        $user_pro->assignRole('promotor');

        $promotore = Promotore::create([
            'dni' => '77778888',
            'celular' => '888887777',
            'user_id' => $user_dev->id
        ]);

        $user_cli = User::create([
            'name' => 'Renzo',
            'lastname' => 'Espinoza',
            'email' => 'renzo@espinoza.com',
            'email_verified_at' => '2022-01-01 12:00:00',
            'password' => Hash::make('123@456')
        ]);

        $user_cli->assignRole('cliente');

        $cliente = Cliente::create([
            'dni' => '77778888',
            'celular' => '888887777',
            'user_id' => $user_cli->id
        ]);

        $billetera = Billetera::create([
            'cliente_id' => $cliente->id,
            'saldo' => 0
        ]);
    }
}
