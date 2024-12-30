<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comprobante;

class ComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comprobante::insert([
            [
                'tipo_comprobante' => 'Boleta'
            ],
            [
                'tipo_comprobante' => 'Factura'
            ]
        ]);
    }
}
