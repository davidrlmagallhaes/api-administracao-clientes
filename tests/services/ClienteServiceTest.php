<?php

use PHPUnit\Framework\TestCase;
require_once 'src/entrypoints/domain/getways/ClienteGetway.php';
require_once 'src/services/ClienteService.php';

class ClienteServiceTest extends TestCase {
    private $gatewayMock;
    private $service;

    protected function setUp(): void {
        $this->gatewayMock = $this->createMock(ClienteGateway::class);
        $this->service = new ClienteService($this->gatewayMock);
    }

    public function testGetAllClientes() {
        $this->gatewayMock->expects($this->once())
                          ->method('getAll')
                          ->willReturn([]);
        $result = $this->service->getAllClientes();
        $this->assertEquals([], $result);
    }

    public function testGetClienteById() {
        $clienteSimulado = ['id' => 1, 'nome' => 'Cliente 1', 'email' => 'cliente1@example.com'];
        $this->gatewayMock->expects($this->once())
                          ->method('getById')
                          ->with(1)
                          ->willReturn($clienteSimulado);
        $result = $this->service->getClienteById(1);
        $this->assertEquals($clienteSimulado, $result);
    }

    public function testAddCliente() {
        $clienteData = ['nome' => 'Novo Cliente', 'email' => 'novo_cliente@example.com'];
        $this->gatewayMock->expects($this->once())
                          ->method('save')
                          ->with($clienteData)
                          ->willReturn(true);
        $result = $this->service->addCliente($clienteData);
        $this->assertTrue($result);
    }

    public function testUpdateCliente() {
        $clienteId = 1;
        $clienteData = ['nome' => 'Novo Nome', 'email' => 'novo_email@example.com'];
        $this->gatewayMock->expects($this->once())
                          ->method('update')
                          ->with($clienteId, $clienteData)
                          ->willReturn(true);
        $result = $this->service->updateCliente($clienteId, $clienteData);
        $this->assertTrue($result);
    }

    public function testRemoveCliente() {
        $clienteId = 1;
        $this->gatewayMock->expects($this->once())
                          ->method('delete')
                          ->with($clienteId)
                          ->willReturn(true);
        $result = $this->service->removeCliente($clienteId);
        $this->assertTrue($result);
    }
}
