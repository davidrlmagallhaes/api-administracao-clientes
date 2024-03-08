<?php

use PHPUnit\Framework\TestCase;
require_once 'src/services/ClienteService.php';
require_once 'src/usecases/DeletarClienteUseCase.php';

class DeletarClienteUseCaseTest extends TestCase {
    
    public function testExecute() {
        $clienteServiceMock = $this->createMock(ClienteService::class);

        $clienteServiceMock->expects($this->once())
                           ->method('removeCliente')
                           ->with(2)
                           ->willReturn(true);

        $useCase = new DeletarClienteUseCase($clienteServiceMock);

        $resultado = $useCase->execute(2);
        $this->assertTrue($resultado);
    }
}
