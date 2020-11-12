<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$pdo = \Alura\Pdo\Infra\Persistence\ConnectionCreator::createConnection();

$student = new Student(
    null,
    'Anderson Rafael Schlender',
    new \DateTimeImmutable('1995-10-05')
);

$statement = $pdo->prepare("INSERT INTO studensts (name, birth_date) VALUES (:name, :birth_date);");
$statement->bindValue(':name', $student->name());
$statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));

var_dump($statement->execute());