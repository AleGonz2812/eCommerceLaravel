<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Verificar si ya existe un usuario admin
        $adminExists = User::where('email', 'admin@admin.com')->exists();
        
        if (!$adminExists) {
            // Crear usuario administrador
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
                'is_admin' => 1,
            ]);

            echo "✅ Usuario administrador creado:\n";
            echo "   Email: admin@admin.com\n";
            echo "   Password: admin\n";
        } else {
            echo "ℹ️  Usuario administrador ya existe:\n";
            echo "   Email: admin@admin.com\n";
            echo "   Password: admin\n";
        }
    }
}
