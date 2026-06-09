<?php

$config = parse_ini_file(__DIR__ . '/../.env'); # Carga el archivo .env desde el directorio raíz del proyecto

if ($config === false) {
    die('No se pudo cargar el archivo .env');
} # Verifica que se hayan cargado las variables de entorno necesarias

try {

    $dsn = sprintf(
        "pgsql:host=%s;port=%s;dbname=%s",
        $config['DB_HOST'],
        $config['DB_PORT'],
        $config['DB_NAME']
    ); # Construye el DSN para la conexión a PostgreSQL utilizando las variables de entorno
    #un DSN (Data Source Name) es una cadena que contiene la información necesaria para conectarse a una base de datos, como el tipo de base de datos, el host, el puerto y el nombre de la base de datos

    $pdo = new PDO(
        $dsn,
        $config['DB_USER'],
        $config['DB_PASSWORD']
    ); # Crea una nueva instancia de PDO para conectarse a la base de datos utilizando el DSN y las credenciales proporcionadas

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    ); # Configura PDO para lanzar excepciones en caso de errores, lo que facilita la depuración y el manejo de errores

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'error' => 'Error de conexión a la base de datos',
        'message' => $e->getMessage()
    ]);

    exit;
}