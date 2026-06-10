<?php

require_once 'config/database.php';

$stmt = $pdo->query(
    'SELECT NOW()'
);

$result = $stmt->fetch(
    PDO::FETCH_ASSOC
);

echo json_encode(
    $result,
    JSON_PRETTY_PRINT
);