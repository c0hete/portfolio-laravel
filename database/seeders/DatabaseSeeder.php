<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Creamos el usuario de prueba (opcional)
        User::factory()->create([
            'name' => 'José Alvarado',
            'email' => 'test@example.com',
        ]);

        // ACTIVAMOS EL SEMBRADO DE PROYECTOS
        $this->call([
            ProjectSeeder::class,
        ]);
    }
}