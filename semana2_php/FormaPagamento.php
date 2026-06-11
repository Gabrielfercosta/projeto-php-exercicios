<?php
declare(strict_types=1);

enum FormaPagamento {
    case PIX;
    case CARTAO;
    case BOLETO;

    public function calcularDesconto(float $valorTotal): float {
        return match($this) {
            FormaPagamento::PIX    => $valorTotal * 0.90, 
            FormaPagamento::BOLETO => $valorTotal * 0.95, 
            FormaPagamento::CARTAO => $valorTotal,       
        };
    }
}