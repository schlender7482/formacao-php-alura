<?php

require_once 'vendor/autoload.php';

use Alura\Pdo\Infra\Persistence\ConnectionCreator;

$connection = ConnectionCreator::createConnection();

$sql = '
    CREATE TABLE IF NOT EXISTS studensts (
        id INTEGER PRIMARY KEY,
        name TEXT,
        birth_date TEXT
    );
    
    CREATE TABLE IF NOT EXISTS phones (
        id INTEGER PRIMARY KEY,
        area_code TEXT,
        number TEXT,
        student_id INTEGER,
        FOREIGN KEY(student_id) REFERENCES studensts(id)
    );
';

$connection->exec($sql);