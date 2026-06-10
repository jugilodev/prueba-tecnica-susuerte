<?php

function jsonResponse(int $status, array $data): void
{
    http_response_code($status);

    header('Content-Type: application/json');

    echo json_encode($data);

    exit;
}