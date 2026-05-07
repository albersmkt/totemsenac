<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Unidade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidades = Unidade::query()->pluck('id');
        if ($unidades->isEmpty()) {
            return;
        }

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

        foreach ($unidades as $unidadeId) {
            foreach ($areas as $name) {
                Area::updateOrCreate(
                    [
                        'unidade_id' => $unidadeId,
                        'slug' => Str::slug($name),
                    ],
                    ['name' => $name]
                );
            }
        }
    }
}
