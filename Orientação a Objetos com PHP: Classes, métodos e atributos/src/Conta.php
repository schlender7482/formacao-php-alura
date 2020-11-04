<?php

class Conta
{
    private float $saldo;
    private Titular $titular;

    public function __construct(Titular $titular, float $saldo = 0)
    {
        $this->saldo = $saldo;
        $this->titular = $titular;
    }

    /**
     * @return float
     */
    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function sacar(float $valor): void
    {
        if ($valor > $this->saldo) {
            echo "Valor indisponível";
            return;
        }
        $this->saldo -= $valor;
    }

    public function depositar(float $valor): void
    {
        if ($valor <= 0) {
            echo "O valor precisa ser posítivo";
            return;
        }
        $this->saldo += $valor;
    }

    public function transferir(float $valor, Conta $conta): void
    {
        if ($valor > $this->saldo) {
            echo "Saldo indisponível";
            return;
        }
        $this->sacar($valor);
        $conta->depositar($valor);
    }
}