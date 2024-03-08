<?php

use PHPUnit\Framework\TestCase;
require_once 'src/services/ClienteService.php';
require_once 'src/usecases/EditarClienteUseCase.php';

class EditarClienteUseCaseTest extends TestCase {
    
    public function testExecute() {

        $clienteServiceMock = $this->createMock(ClienteService::class);

        $clienteData = ['nome' => 'Novo Nome', 'email' => 'novoemail@example.com'];

        $clienteServiceMock->expects($this->once())
                           ->method('updateCliente')
                           ->with(1, $clienteData)
                           ->willReturn(true);

        $useCase = new EditarClienteUseCase($clienteServiceMock);

        $resultado = $useCase->execute(1, $clienteData); 
        $this->assertTrue($resultado);
    }
}
