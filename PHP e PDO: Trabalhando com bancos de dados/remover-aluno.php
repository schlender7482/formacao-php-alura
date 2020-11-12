<?php

require_once 'vendor/autoload.php';

$pdo = \Alura\Pdo\Infra\Persistence\ConnectionCreator::createConnection();

$statement = $pdo->prepare("DELETE FROM studensts WHERE id = ?;");
$statement->bindValue(1, 1, PDO::PARAM_INT);
$statement->execute();