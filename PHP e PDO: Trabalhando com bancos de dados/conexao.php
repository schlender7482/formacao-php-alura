<?php

$pdo = new PDO('sqlite:' . __DIR__ . '/banco.sqlite');

$pdo->exec(
    'CREATE TABLE studensts (
        id INTEGER PRIMARY KEY,
        name TEXT,
        birth_date TEXT
    );'
);