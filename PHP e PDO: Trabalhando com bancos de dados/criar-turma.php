<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infra\Persistence\ConnectionCreator;
use Alura\Pdo\Infra\Repository\PdoStudentRepository;

$connection = ConnectionCreator::createConnection();
$studentRepository = new PdoStudentRepository($connection);

try {
    $connection->beginTransaction();
    $aStudent = new Student(
        null,
        'Nico Steppat',
        new DateTimeImmutable('1995-10-05')
    );
    $studentRepository->save($aStudent);

    $bStudent = new Student(
        null,
        'Sergio Lopes Steppat',
        new DateTimeImmutable('1995-10-05')
    );
    $studentRepository->save($bStudent);

    $connection->commit();
} catch (\PDOException $e) {
    echo $e->getMessage();

    $connection->rollBack();
}