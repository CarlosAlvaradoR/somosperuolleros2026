<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primero cargamos el contenido de campaña para que la landing tenga
        // la misma información base de la maqueta desde el primer arranque.
        $this->call(CampaignSiteSeeder::class);

        // User::factory(10)->create();

        // Usuario mínimo de acceso local. updateOrCreate evita duplicados si se
        // vuelve a ejecutar db:seed durante desarrollo.
        User::query()->updateOrCreate(
            ['email' => 'adminsomosperu@somosperu.com'],
            ['name' => 'Mirko Cacha', 'password' => '12345678']
        );
    }
}
