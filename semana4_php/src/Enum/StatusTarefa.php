<?php
declare(strict_types=1);
namespace App\Enum;

enum StatusTarefa : string{
    case Pendente = 'pendente';
    case EmProgresso = 'em_progresso';
    case Concluida = 'concluida';
    case Cancelada = 'cancelada';
}