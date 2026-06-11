<?php
declare(strict_types=1);

require_once 'Produto.php';
require_once 'ProdutoDAO.php';
require_once 'Carrinho.php';
require_once 'FormaPagamento.php';

$pdo = new PDO("mysql:host=localhost;dbname=loja;charset=utf8mb4", "root", "");
$dao = new ProdutoDAO($pdo);

$novoProduto = new Produto("Teclado", 100, 2);
$novoCarrinho = new Carrinho();
//$dao->salvarProduto($novoProduto);
//$dao->deletarProduto(1);
//print_r($dao->buscarTodos());

try {
    $novoCarrinho->adicionar($novoProduto, 2); 
} catch (Exception $e) {
    echo "Erro na compra: " . $e->getMessage();
}

$totalPix = $novoCarrinho->calcularTotal(FormaPagamento::PIX);
$totalBoleto = $novoCarrinho->calcularTotal(FormaPagamento::BOLETO);
$totalCartao = $novoCarrinho->calcularTotal(FormaPagamento::CARTAO);

echo "Total no Cartão: R$ " . $totalCartao . "<br>";
echo "Total no Boleto (5% de desconto): R$ " . $totalBoleto . "<br>";
echo "Total no PIX (10% de desconto): R$ " . $totalPix . "<br>";