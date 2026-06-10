<?php

$method = $_SERVER['REQUEST_METHOD'];

$uri = parse_url(
    $_SERVER['REQUEST_URI'],
    PHP_URL_PATH
);

$uri = trim($uri, '/');

$segments = explode('/', $uri);

if (
    $method === 'POST'
    && $uri === 'api/tiquetes'
) {

    require __DIR__ . '/create.php';

    exit;
}

if (
    $method === 'GET'
    && count($segments) === 4
    && $segments[0] === 'api'
    && $segments[1] === 'usuarios'
    && $segments[3] === 'tiquetes'
) {

    $_GET['usuario_id'] = $segments[2];

    require __DIR__ . '/list.php';

    exit;
}

jsonResponse(404, [
    'error' => 'Ruta no encontrada'
]);