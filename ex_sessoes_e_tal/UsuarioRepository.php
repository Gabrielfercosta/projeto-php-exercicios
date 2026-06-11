<?php
declare(strict_types=1);

class UsuarioRepository{
    public function __construct(private PDO $conexao){}

    public function criar(string $nome, string $email, string $senha) : int{
        $sql = "INSERT INTO usuarios (nome, email, senha_hash, criado_em) VALUES (:nome, :email, :senha_hash, NOW())";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':email'   => $email,
            ':senha_hash' => password_hash($senha, PASSWORD_ARGON2ID)
        ]);
        return (int) $this->conexao->lastInsertId();
    }

    public function buscarPorEmail(string $email){
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':email' => $email
        ]);
        return $stmt->fetch() ?: null;
    }
}