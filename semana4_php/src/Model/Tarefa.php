<?php

declare(strict_types=1);

namespace App\Model;

use App\Enum\Prioridade;
use App\Enum\StatusTarefa;

class Tarefa
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $titulo,
        public readonly string $descricao,
        public readonly Prioridade $prioridade,
        public readonly StatusTarefa $status,
        public readonly ?string $criadoEm = null,
    ) {}
}
