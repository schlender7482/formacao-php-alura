<?php

function criarConta(string $cpf, string $nome, float $saldo): array
{
    return [
        $cpf => [
            'titular' => $nome,
            'saldo' => $saldo
        ]
    ];
}