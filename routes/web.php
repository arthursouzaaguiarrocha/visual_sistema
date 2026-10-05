<?php

use App\Http\Controllers\AbastecimentosVeiculosController;
use App\Http\Controllers\AcabamentosController;
use App\Http\Controllers\CategoriasFinanceirasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ColaboradoresController;
use App\Http\Controllers\ContasPagarController;
use App\Http\Controllers\ContasReceberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipamentosController;
use App\Http\Controllers\FluxoCaixaController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\ManutencoesEquipamentosController;
use App\Http\Controllers\ManutencoesVeiculosController;
use App\Http\Controllers\MateriasPrimasController;
use App\Http\Controllers\OrcamentosController;
use App\Http\Controllers\OrdensProducaoController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VeiculosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ------------------------------------------------------------ Cadastros
    Route::resource('clientes', ClientesController::class)->except('show')
        ->parameters(['clientes' => 'cliente']);
    Route::resource('colaboradores', ColaboradoresController::class)->except('show')
        ->parameters(['colaboradores' => 'colaborador']);
    Route::resource('fornecedores', FornecedoresController::class)->except('show')
        ->parameters(['fornecedores' => 'fornecedor']);

    // ------------------------------------------------------------ Produção
    Route::resource('materias_primas', MateriasPrimasController::class)->except('show')
        ->parameters(['materias_primas' => 'materia']);
    Route::resource('acabamentos', AcabamentosController::class)->except('show')
        ->parameters(['acabamentos' => 'acabamento']);
    Route::resource('produtos', ProdutosController::class)->except('show')
        ->parameters(['produtos' => 'produto']);

    Route::resource('equipamentos', EquipamentosController::class)
        ->parameters(['equipamentos' => 'equipamento']);
    Route::post('equipamentos/{equipamento}/manutencoes', [ManutencoesEquipamentosController::class, 'store'])
        ->name('equipamentos.manutencoes.store');
    Route::delete('manutencoes_equipamentos/{manutencao}', [ManutencoesEquipamentosController::class, 'destroy'])
        ->name('manutencoes_equipamentos.destroy');

    Route::resource('ordens_producao', OrdensProducaoController::class)
        ->parameters(['ordens_producao' => 'ordem_producao']);

    // ------------------------------------------------------------ Comercial
    Route::resource('orcamentos', OrcamentosController::class)
        ->parameters(['orcamentos' => 'orcamento']);

    // ------------------------------------------------------------ Frota
    Route::resource('veiculos', VeiculosController::class)
        ->parameters(['veiculos' => 'veiculo']);
    Route::post('veiculos/{veiculo}/manutencoes', [ManutencoesVeiculosController::class, 'store'])
        ->name('veiculos.manutencoes.store');
    Route::delete('manutencoes_veiculos/{manutencao}', [ManutencoesVeiculosController::class, 'destroy'])
        ->name('manutencoes_veiculos.destroy');
    Route::post('veiculos/{veiculo}/abastecimentos', [AbastecimentosVeiculosController::class, 'store'])
        ->name('veiculos.abastecimentos.store');
    Route::delete('abastecimentos_veiculos/{abastecimento}', [AbastecimentosVeiculosController::class, 'destroy'])
        ->name('abastecimentos_veiculos.destroy');

    // ------------------------------------------------------------ Financeiro
    Route::resource('categorias_financeiras', CategoriasFinanceirasController::class)->except('show')
        ->parameters(['categorias_financeiras' => 'categoria_financeira']);

    Route::resource('contas_pagar', ContasPagarController::class)->except('show')
        ->parameters(['contas_pagar' => 'conta_pagar']);
    Route::patch('contas_pagar/{conta_pagar}/baixar', [ContasPagarController::class, 'baixar'])
        ->name('contas_pagar.baixar');

    Route::resource('contas_receber', ContasReceberController::class)->except('show')
        ->parameters(['contas_receber' => 'conta_receber']);
    Route::patch('contas_receber/{conta_receber}/baixar', [ContasReceberController::class, 'baixar'])
        ->name('contas_receber.baixar');

    Route::resource('fluxo_caixa', FluxoCaixaController::class)->except('show')
        ->parameters(['fluxo_caixa' => 'movimento']);
});

require __DIR__ . '/auth.php';
