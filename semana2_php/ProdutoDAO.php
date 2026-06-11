<?php
declare(strict_types=1);

class ProdutoDAO{
    public function __construct(private PDO $conexao){}

    public function salvarProduto(Produto $produto) : void{
        $sql = "INSERT INTO produtos (nome, preco) VALUES (:nome, :preco)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':nome' => $produto->nome,
            ':preco'   => $produto->preco
        ]);
    }

    public function deletarProduto(int $id) : void{
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
    }

    public function buscarTodos(): array {
        $sql = "SELECT * FROM produtos";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}