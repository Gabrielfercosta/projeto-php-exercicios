<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\TarefaService;
use App\Exception\ValidationException;
use App\Exception\NotFoundException;

class TarefaController
{
    public function __construct(private TarefaService $service) {}

    public function listar(array $params): array
    {
        $pagina = (int) ($_GET['pagina'] ?? 1);
        return $this->service->listar($pagina);
    }

    public function buscar(array $params): array
    {
        try {
            return $this->service->buscar((int) $params['id']);
        } catch (NotFoundException $e) {
            http_response_code(404);
            return ['erro' => $e->getMessage()];
        }
    }

    public function criar(array $params): array
    {
        try {
            http_response_code(201);
            return $this->service->criar();
        } catch (ValidationException $e) {
            http_response_code(400);
            return ['erro' => $e->getMessage()];
        }
    }

    public function atualizar(array $params): array
    {
        try {
            return $this->service->atualizar((int) $params['id']);
        } catch (ValidationException $e) {
            http_response_code(400);
            return ['erro' => $e->getMessage()];
        } catch (NotFoundException $e) {
            http_response_code(404);
            return ['erro' => $e->getMessage()];
        }
    }

    public function deletar(array $params): array
    {
        return $this->service->deletar((int) $params['id']);
    }
}
