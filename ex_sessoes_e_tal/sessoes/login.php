<?php
session_start();
require_once __DIR__ . '/../UsuarioRepository.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if ($_POST['csrf'] !== $_SESSION['csrf']) {
        die('Token inválido.');
    }

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    
    $pdo = new PDO("mysql:host=localhost;dbname=curso_php;charset=utf8mb4", "root", "");
    $dao = new UsuarioRepository($pdo);
    
    $usuario = $dao->buscarPorEmail($email);
    
    if($usuario && password_verify($senha, $usuario['senha_hash'])){
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nome'];
        header('Location: painel.php');
        exit;
    }else{
        $erro = 'E-mail ou senha incorretos.';
    }
}

$_SESSION['csrf'] = bin2hex(random_bytes(32));
?>

<form method="POST">
    <input type="email" name="email" placeholder="Insira seu email">
    <input type="password" name="senha" placeholder="Insira seu senha">
    <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">
    <button type="submit">Salvar</button>
</form>