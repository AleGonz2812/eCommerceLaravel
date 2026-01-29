<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crear usuario administrador
        $this->call(AdminUserSeeder::class);
        
        // Crear categorías primero
        $this->call(CategorySeeder::class);
        
        // Luego crear productos (dependen de las categorías)
        $this->call(ProductSeeder::class);
        
        // \App\Models\User::factory(10)->create();
    }
}
