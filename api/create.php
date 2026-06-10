<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/response.php';

$body = file_get_contents('php://input');

$data = json_decode(
    $body,
    true
);

if (
    json_last_error()
    !== JSON_ERROR_NONE
) {

    jsonResponse(400, [
        'error' => 'JSON inválido'
    ]);
}

if (
    !isset($data['usuario_id']) ||
    !isset($data['monto'])
) {

    jsonResponse(400, [
        'error' => 'Campos requeridos'
    ]);
}

$usuarioId = (int) $data['usuario_id'];
$monto = (float) $data['monto'];

$stmt = $pdo->prepare(
    "
    SELECT
        id,
        saldo
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

if ($usuario['saldo'] < $monto) {

    jsonResponse(422, [
        'error' => 'Saldo insuficiente'
    ]);
}

try {

    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        "
        UPDATE usuarios
        SET saldo = saldo - ?
        WHERE id = ?
        "
    );

    $stmt->execute([
        $monto,
        $usuarioId
    ]);

    $stmt = $pdo->prepare(
        "
        INSERT INTO tiquetes
        (
            usuario_id,
            monto,
            estado
        )
        VALUES
        (
            ?, ?, 'pendiente'
        )
        RETURNING id
        "
    );

    $stmt->execute([
        $usuarioId,
        $monto
    ]);

    $tiquete = $stmt->fetch(
        PDO::FETCH_ASSOC
    );

    $pdo->commit();

    jsonResponse(201, [
        'message' => 'Tiquete creado',
        'tiquete_id' => $tiquete['id']
    ]);

} catch (Exception $e) {

    $pdo->rollBack();

    jsonResponse(500, [
        'error' => 'Error interno'
    ]);
}