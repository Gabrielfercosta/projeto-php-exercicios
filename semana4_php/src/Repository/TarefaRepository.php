<?php
declare(strict_types=1);
namespace App\Repository;

use App\Enum\StatusTarefa;
use App\Enum\Prioridade;
use PDO;
use App\Exception\NotFoundException;
use App\Exception\ValidationException;


class TarefaRepository{
    public function __construct(private PDO $conexao){}
    
    public function criar(string $titulo, string $descricao, Prioridade $prioridade, StatusTarefa $StatusTarefa) : int{
        $sql = "INSERT INTO tarefas (titulo, descricao, prioridade, status, criado_em) VALUES (:titulo, :descricao, :prioridade, :status, NOW())";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao'   => $descricao,
            ':prioridade' => $prioridade->value,
            ':status' => $StatusTarefa->value
        ]);
        return (int) $this->conexao->lastInsertId();
    }

    public function listar(int $pagina = 1, int $porPagina = 20){
        $offset = ($pagina -1) * $porPagina;
        $sql = "SELECT * FROM tarefas LIMIT :limite OFFSET :offset";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarId(int $id){
        $sql = "SELECT * FROM tarefas WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        $resultado = $stmt->fetch();
        if(!$resultado){
            throw new NotFoundException('Tarefa não encontrada');
        }
        return $resultado;
    }

    public function atualizar(int $id, string $titulo, string $descricao, Prioridade $prioridade, StatusTarefa $status) : bool{
        $sql = "UPDATE tarefas SET titulo = :titulo, descricao = :descricao, prioridade = :prioridade, status = :status WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':prioridade' => $prioridade->value,
            ':status' => $status->value,
            ':id' => $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    public function deletar(int $id){
        $sql = "DELETE FROM tarefas WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->rowCount() > 0;
    }
}

