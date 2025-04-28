<?php

namespace Database\Seeders;

use App\Models\Servico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ServicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        for($i=0; $i <10; $i++) {
            Servico::create([
                'name' => $faker->jobTitle,
                'description' => $faker->paragraph(2),
            ]);
       }

    }
}
