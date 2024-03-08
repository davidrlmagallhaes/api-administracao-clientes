<?php

use PHPUnit\Framework\TestCase;
require_once 'src/services/ClienteService.php';
require_once 'src/usecases/ListarClienteUseCase.php';

class ListarClienteUseCaseTest extends TestCase {
    
    public function testExecute() {
        $clienteServiceMock = $this->createMock(ClienteService::class);
        $clientesSimulados = [
            ['id' => 1, 'nome' => 'Cliente 1', 'email' => 'cliente1@example.com'],
            ['id' => 2, 'nome' => 'Cliente 2', 'email' => 'cliente2@example.com']
        ];
        $clienteServiceMock->expects($this->once())
                           ->method('getAllClientes')
                           ->willReturn($clientesSimulados);
        $useCase = new ListarClienteUseCase($clienteServiceMock);
        $resultado = $useCase->execute();
        $this->assertEquals($clientesSimulados, $resultado);
    }
}
