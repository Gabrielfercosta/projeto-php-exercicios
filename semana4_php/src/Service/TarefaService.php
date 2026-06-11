<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\TarefaRepository;
use App\Enum\Prioridade;
use App\Enum\StatusTarefa;
use App\Exception\ValidationException;

class TarefaService
{
    public function __construct(private TarefaRepository $repository) {}

    public function criar(): array
    {
        $dados = $this->lerBody();
        $this->validarCampos($dados);

        $id = $this->repository->criar(
            $dados['titulo'],
            $dados['descricao'],
            Prioridade::from($dados['prioridade']),
            StatusTarefa::from($dados['status']),
        );

        return [
            'id' => $id,
            'titulo' => $dados['titulo'],
            'status' => $dados['status'],
            'prioridade' => $dados['prioridade'],
        ];
    }

    public function listar(int $pagina = 1): array
    {
        return $this->repository->listar($pagina);
    }

    public function buscar(int $id): array
    {
        return $this->repository->listarId($id);
    }

    public function atualizar(int $id): array
    {
        $dados = $this->lerBody();
        $this->validarCampos($dados);

        $this->repository->atualizar(
            $id,
            $dados['titulo'],
            $dados['descricao'],
            Prioridade::from($dados['prioridade']),
            StatusTarefa::from($dados['status']),
        );

        return ['Registro Alterado'];
    }

    public function deletar(int $id): array
    {
        $this->repository->deletar($id);
        return ['Registro Deletado'];
    }

    private function lerBody(): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);
        if (!$dados) {
            throw new ValidationException('dados não informados');
        }
        return $dados;
    }

    private function validarCampos(array $dados): void
    {
        $titulo = $dados['titulo'] ?? null;
        $descricao = $dados['descricao'] ?? null;

        if (!$titulo) {
            throw new ValidationException('titulo não encontrado');
        }
        if (!$descricao) {
            throw new ValidationException('descricao não informada ou inválida');
        }
    }
}
