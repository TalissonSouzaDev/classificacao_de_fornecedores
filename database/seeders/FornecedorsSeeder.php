<?php

namespace Database\Seeders;

use App\Models\Fornecedor;
use App\Models\Servico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FornecedorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        $cepsSalvador = [
            '41310005', // Águas Claras
            '41615362', // Alto do Coqueirinho
            '41515052', // Bairro da Paz
            '41280184', // Marechal Rondon
            '40040340', // Nazaré
            '40365000', // Liberdade
            '40415640', // Bonfim
            '41181150', // Cabula VI
            '41275234', // Campinas de Pirajá	
            '40157130' // Chame-Chame
        ];
        for($i=0; $i <10; $i++) {
            $fornecedor = Fornecedor::create([
                'razao_social' => $faker->company,
                'cnpj'         => "5474124752147".$i+1,
                'email'        => $faker->unique()->companyEmail,
                'telefone'     => $faker->phoneNumber,
                'cep_sede'     => $cepsSalvador[$i],
            ]);
            $servicosAleatorios = Servico::inRandomOrder()->take(3)->pluck('id');
            $fornecedor->servicos()->attach($servicosAleatorios);
       }
    }
}
