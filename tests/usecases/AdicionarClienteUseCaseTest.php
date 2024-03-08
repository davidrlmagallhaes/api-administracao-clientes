<?php

use PHPUnit\Framework\TestCase;
require_once 'src/services/ClienteService.php';
require_once 'src/usecases/AdicionarClienteUseCase.php';

class AdicionarClienteUseCaseTest extends TestCase {
    public function testExecute() {
        $clienteServiceMock = $this->createMock(ClienteService::class);
        $clienteData = ['nome' => 'João', 'email' => 'joao@example.com'];
        $clienteServiceMock->expects($this->once())
                           ->method('addCliente')
                           ->with($clienteData)
                           ->willReturn(true);
        $useCase = new AdicionarClienteUseCase($clienteServiceMock);
        $resultado = $useCase->execute($clienteData);
        $this->assertTrue($resultado);
    }
}
