<?php
declare(strict_types=1);

class Carrinho{
    private array $itens = [];
    public function adicionar(Produto $produto, int $quantidade){
        $produto->baixarEstoque($quantidade);
        $this->itens[] = [
            'produto' => $produto,
            'quantidade' => $quantidade
        ];
    }

    public function calcularTotal(FormaPagamento $pagamento){
        $totalBruto = 0;
        foreach($this->itens as $item){
            $totalBruto += $item['produto']->preco * $item['quantidade'];
        }
        return $pagamento->calcularDesconto($totalBruto);
    }
}