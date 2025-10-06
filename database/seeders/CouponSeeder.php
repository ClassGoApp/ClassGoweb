<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('coupons')->insert([
            'nombre' => 'Cupon de Bienvenida',
            'codigo' => 'CLASSGO1', 
            'fecha_caducidad' => null,
            'estado' => 'activo',
            'descuento' => 100.00,
            'cantidad' => 5,
            'referencia' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
