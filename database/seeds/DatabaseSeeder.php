<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        App\Empresa::create([
            'descripcion'    => 'CORPORACION INDY KNIT S.A.',        
        ]);
        App\Empresa::create([
            'descripcion'    => 'SAE A.',        
        ]);

        App\Estilo::create([
            'descripcion'    => 'OFA',        
        ]);
        App\Estilo::create([
            'descripcion'    => 'SPEEDWICK',        
        ]);

        App\Calibre::create([
            'descripcion'    => 'TEX 150D',        
        ]);
        App\Calibre::create([
            'descripcion'    => '40/2',        
        ]);

        App\Metraje::create([
            'descripcion'    => 'KLS',        
        ]);
        App\Metraje::create([
            'descripcion'    => '2500',        
        ]);

        App\Color::create([
            'descripcion'    => 'DRM MAROON MELANGE',        
        ]);
        App\Color::create([
            'descripcion'    => 'DARK HUNTER',        
        ]);

        App\Referencia::create([
            'descripcion'    => 'NATURAL',        
        ]);
        App\Referencia::create([
            'descripcion'    => 'IGUAL ANTERIOR',        
        ]);

        App\Lugar::create([
            'descripcion'    => 'IKC2',        
        ]);
        App\Lugar::create([
            'descripcion'    => 'OFICINA INT/PATTY',        
        ]);

        App\Usuarios::create([
            'nombre'                => 'Jesús Morales',
            'usuario'               => 'jmorales',
            'password'             => bcrypt('admin'),
            'email'                 => 'jmorales',
            'registro'              => '1',
            'administracion'        => '1',
            'produccion'            => '1',
            'compras'               => '1',
            'despachos'             => '1',
            'control'               => '1',
            'usuarios'              => '1',
            
        ]);

        App\Usuarios::create([
            'nombre'                => 'Vinicio Lopez',
            'usuario'               => 'vlopez  ',
            'password'             => bcrypt('admin'),
            'email'                 => 'jmorales',
            'registro'              => '1',
            'administracion'        => '1',
            'produccion'            => '1',
            'compras'               => '1',
            'despachos'             => '1',
            'control'               => '1',
            'usuarios'              => '1',
            
        ]);
    }
}
