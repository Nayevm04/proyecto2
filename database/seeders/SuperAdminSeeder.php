<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nombre' => 'Super',
            'apellido' => 'Admin',
            'cedula' => '000000000',
            'fecha_nacimiento' => '1990-01-01',
            'email' => 'superadmin@aventones.com',
            'telefono' => '888888888',
            'fotografia' => null,
            'password' => Hash::make('super1234'),
            'rol' => 'superadmin',
            'estado' => 'Activo',
            'activation_token' => null,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
