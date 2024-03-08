<?php

use PHPUnit\Framework\TestCase;
require_once 'src/services/ClienteService.php';
require_once 'src/usecases/ObterClientePorIdUseCase.php';

class ObterClientePorIdUseCaseTest extends TestCase {
    
    public function testExecute() {
        $clienteServiceMock = $this->createMock(ClienteService::class);
        $clienteSimulado = ['id' => 1, 'nome' => 'Cliente 1', 'email' => 'cliente1@example.com'];
        $clienteServiceMock->expects($this->once())
                           ->method('getClienteById')
                           ->with(1)
                           ->willReturn($clienteSimulado);
        $useCase = new ObterClientePorIdUseCase($clienteServiceMock);
        $resultado = $useCase->execute(1);
        $this->assertEquals($clienteSimulado, $resultado);
    }
}
