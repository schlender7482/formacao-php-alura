<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$pdo = new PDO('sqlite:' . __DIR__ . '/banco.sqlite');

$student = new Student(null, 'Anderson Rafael', new \DateTimeImmutable('1995-10-05'));
$sqlInsert = "INSERT INTO studensts (name, birth_date) VALUES ('{$student->name()}', '{$student->birthDate()->format('Y-m-d')}');";

var_dump($pdo->exec($sqlInsert));