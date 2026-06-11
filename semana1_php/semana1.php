<?php
declare(strict_types=1); 

$valoresPedidos = [
    "Mouse"=> 20,
    "Teclado"=> 103,
    "Monitor"=> 1000,
    ];

$pedidosGrandes = array_filter($valoresPedidos, fn($valor) => $valor > 100.00);

foreach($pedidosGrandes as &$pedido){
    $pedido = $pedido * 0.85;
}

print_r($pedidosGrandes);