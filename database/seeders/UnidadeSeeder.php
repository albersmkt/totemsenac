<?php

namespace Database\Seeders;

use App\Models\Unidade;
use Illuminate\Database\Seeder;

class UnidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $renames = [
            'Senac Tatuapé' => 'Senac Tatuapé Cel. Luís Americano',
            'Senac Serra de Bragança' => 'Senac Tatuapé Serra de Bragança',
        ];

        foreach ($renames as $oldName => $newName) {
            $existing = Unidade::where('nome', $oldName)->first();

            if ($existing && ! Unidade::where('nome', $newName)->whereKeyNot($existing->id)->exists()) {
                $existing->update(['nome' => $newName]);
            }
        }

        $items = [
            ['nome' => 'Centro Universitário Senac - Santo Amaro', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Aclimação', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Francisco Matarazzo', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Itaquera', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Jabaquara', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Jardim Primavera', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Lapa Faustolo', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Lapa Scipião', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Lapa Tito', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Largo Treze', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Penha', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Nações Unidas', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Santana', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac São Miguel Paulista', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Tatuapé Cel. Luís Americano', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Tatuapé Serra de Bragança', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Taubaté', 'cidade' => 'Taubaté'],
            ['nome' => 'Senac Tiradentes', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Vila Prudente', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Bertioga', 'cidade' => 'Bertioga'],
            ['nome' => 'Senac Guarulhos Celestino', 'cidade' => 'Guarulhos'],
            ['nome' => 'Senac Guarulhos Faccini', 'cidade' => 'Guarulhos'],
            ['nome' => 'Senac Osasco', 'cidade' => 'Osasco'],
            ['nome' => 'Senac Santos', 'cidade' => 'Santos'],
            ['nome' => 'Senac Santo André', 'cidade' => 'Santo André'],
            ['nome' => 'Senac São Bernardo do Campo', 'cidade' => 'São Bernardo do Campo'],
            ['nome' => 'Senac Taboão da Serra', 'cidade' => 'Taboão da Serra'],
            ['nome' => 'Senac Americana', 'cidade' => 'Americana'],
            ['nome' => 'Senac Araçatuba', 'cidade' => 'Araçatuba'],
            ['nome' => 'Senac Araraquara', 'cidade' => 'Araraquara'],
            ['nome' => 'Senac Barretos', 'cidade' => 'Barretos'],
            ['nome' => 'Senac Bauru', 'cidade' => 'Bauru'],
            ['nome' => 'Senac Bebedouro', 'cidade' => 'Bebedouro'],
            ['nome' => 'Senac Botucatu', 'cidade' => 'Botucatu'],
            ['nome' => 'Senac Campinas', 'cidade' => 'Campinas'],
            ['nome' => 'Senac Catanduva', 'cidade' => 'Catanduva'],
            ['nome' => 'Centro Universitário Senac - Águas de São Pedro', 'cidade' => 'Águas de São Pedro'],
            ['nome' => 'Centro Universitário Senac - Campos do Jordão', 'cidade' => 'Campos do Jordão'],
            ['nome' => 'Senac Franca', 'cidade' => 'Franca'],
            ['nome' => 'Senac Guaratinguetá', 'cidade' => 'Guaratinguetá'],
            ['nome' => 'Senac Itapetininga', 'cidade' => 'Itapetininga'],
            ['nome' => 'Senac Itapira', 'cidade' => 'Itapira'],
            ['nome' => 'Senac Itu', 'cidade' => 'Itu'],
            ['nome' => 'Senac Jaboticabal', 'cidade' => 'Jaboticabal'],
            ['nome' => 'Senac Jaú', 'cidade' => 'Jaú'],
            ['nome' => 'Senac Jundiaí', 'cidade' => 'Jundiaí'],
            ['nome' => 'Senac Limeira', 'cidade' => 'Limeira'],
            ['nome' => 'Senac Marília', 'cidade' => 'Marília'],
            ['nome' => 'Senac Mogi Guaçu', 'cidade' => 'Mogi Guaçu'],
            ['nome' => 'Senac Ourinhos', 'cidade' => 'Ourinhos'],
            ['nome' => 'Senac Pindamonhangaba', 'cidade' => 'Pindamonhangaba'],
            ['nome' => 'Senac Piracicaba', 'cidade' => 'Piracicaba'],
            ['nome' => 'Senac Presidente Prudente', 'cidade' => 'Presidente Prudente'],
            ['nome' => 'Senac Registro', 'cidade' => 'Registro'],
            ['nome' => 'Senac Ribeirão Preto', 'cidade' => 'Ribeirão Preto'],
            ['nome' => 'Senac Rio Claro', 'cidade' => 'Rio Claro'],
            ['nome' => 'Senac Salto', 'cidade' => 'Salto'],
            ['nome' => 'Senac São Carlos', 'cidade' => 'São Carlos'],
            ['nome' => 'Senac São João da Boa Vista', 'cidade' => 'São João da Boa Vista'],
            ['nome' => 'Senac São José do Rio Preto', 'cidade' => 'São José do Rio Preto'],
            ['nome' => 'Senac São José dos Campos', 'cidade' => 'São José dos Campos'],
            ['nome' => 'Senac Sorocaba', 'cidade' => 'Sorocaba'],
            ['nome' => 'Senac Votuporanga', 'cidade' => 'Votuporanga'],
        ];

        foreach ($items as $item) {
            Unidade::updateOrCreate(
                ['nome' => $item['nome']],
                ['cidade' => $item['cidade']]
            );
        }
    }
}
