<?php

require_once 'config/database.php';

$stmt = $pdo->query("SELECT NOW()");

$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo "Conexion exitosa\n";
echo $result['now'];