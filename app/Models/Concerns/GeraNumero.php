<?php

namespace App\Models\Concerns;

trait GeraNumero
{
    /**
     * Gera o próximo número sequencial do ano (ex: ORC-2026-0001).
     * Considera registros apagados (soft delete) porque a coluna é unique.
     */
    public static function gerarNumero(): string
    {
        $prefixo = static::PREFIXO_NUMERO . '-' . date('Y') . '-';

        $ultimo = static::withTrashed()
            ->where('numero', 'like', $prefixo . '%')
            ->orderByDesc('numero')
            ->value('numero');

        $sequencia = $ultimo ? ((int) substr($ultimo, strlen($prefixo))) + 1 : 1;

        return $prefixo . str_pad((string) $sequencia, 4, '0', STR_PAD_LEFT);
    }
}
