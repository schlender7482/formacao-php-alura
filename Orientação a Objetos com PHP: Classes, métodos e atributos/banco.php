<?php

require_once 'src/Conta.php';
require_once 'src/Titular.php';

$primeiraConta = new Conta(new Titular('078.939.299-28', 'Anderson Rafael Schlender'), 500);
echo $primeiraConta->getSaldo();