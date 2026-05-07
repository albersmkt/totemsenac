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
        $items = [
            ['nome' => 'Senac Registro', 'cidade' => 'Registro'],
            ['nome' => 'Senac Sorocaba', 'cidade' => 'Sorocaba'],
            ['nome' => 'Senac Lapa Tito', 'cidade' => 'São Paulo'],
            ['nome' => 'Centro Universitário Senac - Águas de São Pedro', 'cidade' => 'Águas de São Pedro'],
            ['nome' => 'Centro Universitário Senac - Campos do Jordão', 'cidade' => 'Campos do Jordão'],
            ['nome' => 'Centro Universitário Senac - Santo Amaro', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Aclimação', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Americana', 'cidade' => 'Americana'],
            ['nome' => 'Senac Araçatuba', 'cidade' => 'Araçatuba'],
            ['nome' => 'Senac Araraquara', 'cidade' => 'Araraquara'],
            ['nome' => 'Senac Barretos', 'cidade' => 'Barretos'],
            ['nome' => 'Senac Bauru', 'cidade' => 'Bauru'],
            ['nome' => 'Senac Bebedouro', 'cidade' => 'Bebedouro'],
            ['nome' => 'Senac Bertioga', 'cidade' => 'Bertioga'],
            ['nome' => 'Senac Birigui', 'cidade' => 'Birigui'],
            ['nome' => 'Senac Botucatu', 'cidade' => 'Botucatu'],
            ['nome' => 'Senac Campinas', 'cidade' => 'Campinas'],
            ['nome' => 'Senac Catanduva', 'cidade' => 'Catanduva'],
            ['nome' => 'Senac Franca', 'cidade' => 'Franca'],
            ['nome' => 'Senac Francisco Matarazzo', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Guaratinguetá', 'cidade' => 'Guaratinguetá'],
            ['nome' => 'Senac Guarulhos Celestino', 'cidade' => 'Guarulhos'],
            ['nome' => 'Senac Guarulhos Faccini', 'cidade' => 'Guarulhos'],
            ['nome' => 'Senac Itapetininga', 'cidade' => 'Itapetininga'],
            ['nome' => 'Senac Itapira', 'cidade' => 'Itapira'],
            ['nome' => 'Senac Itaquera', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Itu', 'cidade' => 'Itu'],
            ['nome' => 'Senac Jabaquara', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Jaboticabal', 'cidade' => 'Jaboticabal'],
            ['nome' => 'Senac Jardim Primavera', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Jaú', 'cidade' => 'Jaú'],
            ['nome' => 'Senac Jundiaí', 'cidade' => 'Jundiaí'],
            ['nome' => 'Senac Lapa Faustolo', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Lapa Scipião', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Largo Treze', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Limeira', 'cidade' => 'Limeira'],
            ['nome' => 'Senac Marília', 'cidade' => 'Marília'],
            ['nome' => 'Senac Mogi Guaçu', 'cidade' => 'Mogi Guaçu'],
            ['nome' => 'Senac Nações Unidas', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Osasco', 'cidade' => 'Osasco'],
            ['nome' => 'Senac Ourinhos', 'cidade' => 'Ourinhos'],
            ['nome' => 'Senac Penha', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Pindamonhangaba', 'cidade' => 'Pindamonhangaba'],
            ['nome' => 'Senac Piracicaba', 'cidade' => 'Piracicaba'],
            ['nome' => 'Senac Presidente Prudente', 'cidade' => 'Presidente Prudente'],
            ['nome' => 'Senac Ribeirão Preto', 'cidade' => 'Ribeirão Preto'],
            ['nome' => 'Senac Rio Claro', 'cidade' => 'Rio Claro'],
            ['nome' => 'Senac Salto', 'cidade' => 'Salto'],
            ['nome' => 'Senac Santana', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Santo André', 'cidade' => 'Santo André'],
            ['nome' => 'Senac Santos', 'cidade' => 'Santos'],
            ['nome' => 'Senac São Bernardo do Campo', 'cidade' => 'São Bernardo do Campo'],
            ['nome' => 'Senac São Carlos', 'cidade' => 'São Carlos'],
            ['nome' => 'Senac São João da Boa Vista', 'cidade' => 'São João da Boa Vista'],
            ['nome' => 'Senac São José do Rio Preto', 'cidade' => 'São José do Rio Preto'],
            ['nome' => 'Senac São José dos Campos', 'cidade' => 'São José dos Campos'],
            ['nome' => 'Senac São Miguel Paulista', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Serra de Bragança', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Taboão da Serra', 'cidade' => 'Taboão da Serra'],
            ['nome' => 'Senac Tatuapé', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Taubaté', 'cidade' => 'Taubaté'],
            ['nome' => 'Senac Tiradentes', 'cidade' => 'São Paulo'],
            ['nome' => 'Senac Vila Prudente', 'cidade' => 'São Paulo'],
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
