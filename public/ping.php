<?php
require __DIR__ . '/../app/config.php';
echo "Connected!\n";
$stmt = $pdo->query('SELECT NOW() now, (SELECT COUNT(*) FROM contacts) total');
var_dump($stmt->fetch());