<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/response.php';

$usuarioId = (int) $_GET['usuario_id'];

$stmt = $pdo->prepare(
    "
    SELECT id
    FROM usuarios
    WHERE id = ?
    "
);

$stmt->execute([
    $usuarioId
]);

$usuario = $stmt->fetch(
    PDO::FETCH_ASSOC
);

if (!$usuario) {

    jsonResponse(404, [
        'error' => 'Usuario no encontrado'
    ]);
}

$stmt = $pdo->prepare(
    "
    SELECT
        id,
        monto,
        estado,
        creado_en
    FROM tiquetes
    WHERE usuario_id = ?
    ORDER BY creado_en DESC
    "
);

$stmt->execute([
    $usuarioId
]);

$tiquetes = $stmt->fetchAll(
    PDO::FETCH_ASSOC
);

jsonResponse(
    200,
    $tiquetes
);