<?php
$dsn = 'mysql:host=127.0.0.1;port=3306;dbname=mysql';
$user = 'root';
$pass = '';
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$dbName = 'db_simac_dev';
$charset = 'utf8mb4';
$collation = 'utf8mb4_unicode_ci';
$pdo->exec('CREATE DATABASE IF NOT EXISTS `' . $dbName . '` CHARACTER SET ' . $charset . ' COLLATE ' . $collation);
echo "Created or exists: {$dbName}\n";
