<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            'Beleza e Estética',
            'Bem-estar',
            'Comunicação e Marketing',
            'Desenvolvimento Social',
            'Design, Artes e Arquitetura',
            'Educação',
            'Gastronomia e Alimentação',
            'Gestão e Negócios',
            'Idiomas',
            'Meio Ambiente',
            'Segurança e Saúde no Trabalho',
            'Moda',
            'Saúde',
            'Tecnologia da Informação',
            'Turismo e Hospitalidade',
        ];

        foreach ($areas as $name) {
            Area::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}
