<?php

namespace Tests\Enum;

use PHPUnit\Framework\TestCase;
use App\Enum\StatusTarefa;

class StatusTarefaTest extends TestCase{
    public function testValorPendente(): void{
        $this->assertSame('pendente', StatusTarefa::Pendente->value);
    }

    public function testValorEmProgresso(): void {
        $this->assertSame('em_progresso', StatusTarefa::EmProgresso->value);
    }

    public function testFromString(): void {
        $this->assertSame(StatusTarefa::Concluida, StatusTarefa::from('concluida'));
    }

    public function testFromInvalido(): void {
        $this->expectException(\ValueError::class);
        StatusTarefa::from('invalido');
    }
}