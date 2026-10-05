<?php

namespace Database\Seeders;

use App\Models\CategoriaFinanceira;
use Illuminate\Database\Seeder;

class CategoriaFinanceiraSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'receita' => ['Vendas', 'Serviços de instalação', 'Outras receitas'],
            'despesa' => ['Insumos / Matéria-prima', 'Aluguel', 'Energia e água', 'Salários', 'Combustível',
                'Manutenção de equipamentos', 'Manutenção de veículos', 'Impostos', 'Marketing', 'Outras despesas'],
        ];

        foreach ($categorias as $tipo => $nomes) {
            foreach ($nomes as $nome) {
                CategoriaFinanceira::firstOrCreate(['nome' => $nome, 'tipo' => $tipo]);
            }
        }
    }
}
