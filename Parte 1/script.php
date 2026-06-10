<?php

function calcularPremioAcumulado(array $niveles): float
{
    if (empty($niveles)) {
        return 0;
    }

    $nodo = $niveles[0];

    return
        $nodo['monto']
        + calcularPremioAcumulado($nodo['hijos'])
        + calcularPremioAcumulado(array_slice($niveles, 1)); 
}

$niveles = [
    [
        'monto' => 1000,
        'hijos' => [
            [
                'monto' => 500,
                'hijos' => []
            ],
            [
                'monto' => 250,
                'hijos' => [
                    [
                        'monto' => 100,
                        'hijos' => []
                    ]
                ]
            ]
        ]
    ]
];

echo calcularPremioAcumulado($niveles);
