<?php
$dsn = 'mysql:host=127.0.0.1;port=3306;dbname=db_simac';
$user = 'root';
$pass = '';
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
$tables = ['migrations', 'sessions', 'cache', 'jobs', 'failed_jobs'];
foreach ($tables as $t) {
    try {
        $pdo->exec('DROP TABLE IF EXISTS `' . $t . '`;');
        echo "Dropped {$t}\n";
    } catch (Throwable $e) {
        echo $e->getMessage() . "\n";
    }
}
