<?php

session_start();
require_once __DIR__ . '/../UsuarioRepository.php';

$pdo = new PDO("mysql:host=localhost;dbname=curso_php;charset=utf8mb4", "root", "");
$dao = new UsuarioRepository($pdo);


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if ($_POST['csrf'] !== $_SESSION['csrf']){
        die("token inválido.");
    }
        
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        $dao->criar($nome, $email, $senha);
}
        
$_SESSION['csrf'] = bin2hex(random_bytes(32));
?>

<form method="POST">
    <input type="text" name="nome" placeholder="Insira seu nome">
    <input type="email" name="email" placeholder="Insira seu email">
    <input type="password" name="senha" placeholder="Insira seu senha">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    <button type="submit">Salvar</button>
</form>
