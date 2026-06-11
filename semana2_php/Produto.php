<?php
declare(strict_types=1);

class Produto{
    public function __construct(public string $nome, public int $preco, private int $estoque){
    }

    public function getEstoque() : int{
        return $this->estoque;
    }

    public function baixarEstoque(int $quantidade){
        if($quantidade > $this->estoque){
            throw new Exception("Erro");
        }
        $this->estoque -= $quantidade;
    }
}