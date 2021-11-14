<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Registro;
use App\Models\Ajustes;
use MongoDB\BSON\Decimal128;
use App\Models\User;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Creación de registros
        Registro::create([
            'temperatura'=>new Decimal128(36),
            'protocoloCompleto'=> true,
            'conMascarilla'=> true,
            'sinMascarilla'=> true,
            'usoDeGel' => new Decimal128(0.04),
            'foto'=> '/imgs/sin-mascarilla.png',
        ]);

        Registro::create([
            'temperatura'=>new Decimal128(33.7),
            'protocoloCompleto'=> true,
            'conMascarilla'=> true,
            'sinMascarilla'=> true,
            'usoDeGel' => new Decimal128(0.04),
            'foto'=> '/imgs/sin-mascarilla.png',
        ]);

        Registro::create([
            'temperatura'=>new Decimal128(34),
            'protocoloCompleto'=> true,
            'conMascarilla'=> true,
            'sinMascarilla'=> true,
            'usoDeGel' => new Decimal128(0.04),
            'foto'=> '/imgs/sin-mascarilla.png',
        ]);

        Registro::create([
            'temperatura'=>new Decimal128(35),
            'protocoloCompleto'=> true,
            'conMascarilla'=> true,
            'sinMascarilla'=> true,
            'usoDeGel' => new Decimal128(0.04),
            'foto'=> '/imgs/sin-mascarilla.png',
        ]);

        Registro::create([
            'temperatura'=>new Decimal128(38),
            'protocoloCompleto'=> true,
            'conMascarilla'=> true,
            'sinMascarilla'=> true,
            'usoDeGel' => new Decimal128(0.04),
            'foto'=> '/imgs/sin-mascarilla.png',
        ]);

        Ajustes::create([
            'temperatura' => new Decimal128(37.5),
        ]);

	User::create([
	    'name'=>'Administrador',
	    'email'=>'admin@gmail.com',
	    'password'=>Hash::make('adminItca')	
	]);
    }
}
