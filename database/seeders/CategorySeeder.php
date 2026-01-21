<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Videojuegos',
                'slug' => 'videojuegos',
                'image' => 'categories/videojuegos.jpg'
            ],
            [
                'name' => 'Tarjetas de Suscripción',
                'slug' => 'tarjetas-suscripcion',
                'image' => 'categories/suscripciones.jpg'
            ],
            [
                'name' => 'Tarjetas PSN/Xbox/Steam',
                'slug' => 'tarjetas-gaming',
                'image' => 'categories/tarjetas-gaming.jpg'
            ],
            [
                'name' => 'Mystery Keys',
                'slug' => 'mystery-keys',
                'image' => 'categories/mystery-keys.jpg'
            ],
            [
                'name' => 'Software',
                'slug' => 'software',
                'image' => 'categories/software.jpg'
            ]
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'image' => $category['image'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
