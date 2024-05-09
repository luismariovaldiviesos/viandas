<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Entrada;
use App\Models\Postre;
use App\Models\Pp;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InicialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = Customer::create([
            'businame' => 'Carlos Perez',
            'typeidenti' => 'ci',
            'valueidenti' => '0999999999',
            'address' => 'dirección',
            'address' => 'dirección',
            'email' => 'final@mail',
            'phone' => '999999',
            'notes' => 'consumidor final por defecto'
        ]);


        Setting::create([
            'razonSocial' => 'VIANDAS LA AURORA',
            'nombreComercial' => 'VIANDAS LA AURORA',
            'ruc' => '0103844494001',
            'estab' => '001',
            'ptoEmi' => '001',
            'dirMatriz' => 'Dávila Chica y Manuel Moreno',
            'dirEstablecimiento' => 'Dávila Chica y Manuel Moreno',
            'telefono' => '0987308688',
            'email'=> 'khipusistemas@gmail.com',
            'ambiente' => '001',
            'tipoEmision' => '001',
            'contribuyenteEspecial' => 'revisar',
            'obligadoContabilidad' => 'NO',
            'logo' => 'noImage.jpg',
            'leyend' => 'Gracias por su compra',
            'printer' => 'epson',
        ]);


        Entrada::create([
            'descripcion' => 'NA',
            'precio' => 0.00
        ]);
        Entrada::create([
            'descripcion' => 'Sopa de lenteja',
            'precio' => 0.50
        ]);
        Entrada::create([
            'descripcion' => 'Sopa de fideo',
            'precio' => 0.50
        ]);
        Entrada::create([
            'descripcion' => 'Caldo de res',
            'precio' => 0.50
        ]);
        Entrada::create([
            'descripcion' => 'Sopa de Arveja',
            'precio' => 0.50
        ]);

        Pp::create([
            'descripcion' => 'NA',
            'precio' => 0.00
        ]);
        Pp::create([
            'descripcion' => 'Lomo salteado',
            'precio' => 2.25
        ]);
        Pp::create([
            'descripcion' => 'Seco de pollo',
            'precio' => 2.25
        ]);
        Pp::create([
            'descripcion' => 'Arroz con camarones',
            'precio' => 2.25
        ]);
        Pp::create([
            'descripcion' => 'Corvina',
            'precio' => 2.25
        ]);

        Postre::create([
            'descripcion' => 'NA',
            'precio' => 0.00
        ]);
        Postre::create([
            'descripcion' => 'tres leches',
            'precio' => 0.25
        ]);
        Postre::create([
            'descripcion' => 'duraznos en almibar',
            'precio' => 0.25
        ]);
        Postre::create([
            'descripcion' => 'torta de chocolate',
            'precio' => 0.25
        ]);
        Postre::create([
            'descripcion' => 'fruta confitada',
            'precio' => 0.25
        ]);

    }
}
