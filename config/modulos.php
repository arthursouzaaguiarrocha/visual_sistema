<?php

// Menu / atalhos do sistema: 'Grupo' => [['Rótulo', 'prefixo-da-rota'], ...]
// O prefixo precisa ter a rota "<prefixo>.index".
return [
    'Comercial' => [
        ['Orçamentos', 'orcamentos'],
        ['Clientes', 'clientes'],
    ],
    'Produção' => [
        ['Ordens de produção', 'ordens_producao'],
        ['Produtos', 'produtos'],
        ['Matérias-primas', 'materias_primas'],
        ['Acabamentos', 'acabamentos'],
        ['Equipamentos', 'equipamentos'],
    ],
    'Frota' => [
        ['Veículos', 'veiculos'],
    ],
    'Financeiro' => [
        ['Contas a receber', 'contas_receber'],
        ['Contas a pagar', 'contas_pagar'],
        ['Fluxo de caixa', 'fluxo_caixa'],
        ['Categorias', 'categorias_financeiras'],
    ],
    'Cadastros' => [
        ['Fornecedores', 'fornecedores'],
        ['Colaboradores', 'colaboradores'],
    ],
];
