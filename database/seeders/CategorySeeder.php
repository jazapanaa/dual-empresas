<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Desinfectantes y Alcoholes', 'description' => 'Productos como alcohol, isopropílico, sanitizantes y desinfectantes.'],
            ['name' => 'Detergentes y Jabones', 'description' => 'Detergentes en polvo, líquidos, jabones líquidos y en barra.'],
            ['name' => 'Ambientadores y Desodorizantes', 'description' => 'Sprays, repuestos y ambientadores automáticos.'],
            ['name' => 'Ceras y Pulidores', 'description' => 'Ceras líquidas, en pasta y productos para lustrado.'],
            ['name' => 'Limpiadores Multiusos', 'description' => 'Limpiavidrios, limpia todo y productos multiusos.'],
            ['name' => 'Desatoradores', 'description' => 'Líquidos, tirabuzones y herramientas para desatorar cañerías.'],
            ['name' => 'Insecticidas y Repelentes', 'description' => 'Sprays contra insectos, zancudos y ácaros.'],
            ['name' => 'Papeles Higiénicos y Toallas', 'description' => 'Papel higiénico, toalla de mano, jumbo y sabanillas.'],
            ['name' => 'Servilletas y Pañuelos', 'description' => 'Servilletas, pañuelos faciales e industriales.'],
            ['name' => 'Guantes y Protección Personal', 'description' => 'Guantes de látex, industriales y quirúrgicos.'],
            ['name' => 'Mascarillas y Protección Respiratoria', 'description' => 'Mascarillas KN95, quirúrgicas y de tela.'],
            ['name' => 'Bolsas Plásticas', 'description' => 'Bolsas negras, rojas, blancas en diversos tamaños.'],
            ['name' => 'Trapeadores y Escobas', 'description' => 'Trapeadores, escobas, mopa y jaladores.'],
            ['name' => 'Trapos y Paños de Limpieza', 'description' => 'Franela, trapo industrial, microfibra y paños absorbentes.'],
            ['name' => 'Dispensadores', 'description' => 'Dispensadores de jabón, papel higiénico y toalla.'],
            ['name' => 'Baldes y Recipientes', 'description' => 'Baldes, contenedores, y productos similares.'],
            ['name' => 'Papeleras y Tachos', 'description' => 'Papeleras automáticas, con pedal y vaivén.'],
            ['name' => 'Productos de Vidrio y Espejos', 'description' => 'Limpiadores especializados para vidrio.'],
            ['name' => 'Lavavajillas', 'description' => 'Líquidos y pastas para lavar vajilla.'],
            ['name' => 'Aromatizantes y Silicona', 'description' => 'Siliconas en spray, aromatizantes y sprays varios.'],
            ['name' => 'Higiene Personal', 'description' => 'Jabones de tocador, gel antibacterial, shampoo y más.'],
            ['name' => 'Accesorios de Limpieza', 'description' => 'Gatillos, repuestos, esponjas, afiladores y cepillos.'],
            ['name' => 'Equipos Electrónicos de Higiene', 'description' => 'Secadores de manos automáticos, termómetros.'],
            ['name' => 'Otros', 'description' => 'Productos que no se ajustan a una categoría específica.'],
        ];

        DB::table('categories')->insert($categories);
    }
}
