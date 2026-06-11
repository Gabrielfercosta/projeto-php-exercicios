<?php
declare(strict_types=1);
namespace App\Enum;

enum Prioridade : string{
    case Baixa = 'baixa';
    case Media = 'media';
    case Alta = 'alta';
    case Urgente = 'urgente';
}