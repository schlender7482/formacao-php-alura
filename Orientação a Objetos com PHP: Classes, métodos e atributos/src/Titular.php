<?php

class Titular
{
    private string $cpf;
    private string $nome;

    public function __construct(string $cpf, string $nome)
    {
        $this->cpf = $this->validarCpf($cpf);
        $this->nome = $this->validaNome($nome);
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    private function validaNome($nome): string
    {
        if (strlen($nome) < 5) {
            echo "Nome muito curto.";
            die;
        }
        return $nome;
    }

    private function validarCpf($cpf): string
    {
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            echo "Não é um CPF válido.";
            die;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            echo "Não é um CPF válido.";
            die;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                echo "Não é um CPF válido.";
                die;
            }
        }
        return $cpf;
    }
}