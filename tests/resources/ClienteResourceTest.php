<?php

use PHPUnit\Framework\TestCase;
require_once 'src/services/ClienteService.php';
require_once 'src/entrypoints/ClienteResource.php';
require_once 'src/usecases/ListarClienteUseCase.php';
require_once 'src/usecases/AdicionarClienteUseCase.php';
require_once 'src/usecases/ObterClientePorIdUseCase.php';
require_once 'src/usecases/EditarClienteUseCase.php';
require_once 'src/usecases/DeletarClienteUseCase.php';


class ClienteResourceTest extends TestCase {
    private $listarClienteUseCaseMock;
    private $adicionarClienteUseCaseMock;
    private $obterClientePorIdUseCaseMock;
    private $editarClienteUseCaseMock;
    private $deletarClienteUseCaseMock;
    private $clienteResource;

    protected function setUp(): void {
        $this->listarClienteUseCaseMock = $this->createMock(ListarClienteUseCase::class);
        $this->adicionarClienteUseCaseMock = $this->createMock(AdicionarClienteUseCase::class);
        $this->obterClientePorIdUseCaseMock = $this->createMock(ObterClientePorIdUseCase::class);
        $this->editarClienteUseCaseMock = $this->createMock(EditarClienteUseCase::class);
        $this->deletarClienteUseCaseMock = $this->createMock(DeletarClienteUseCase::class);
        $this->clienteResource = new ClienteResource(
            $this->listarClienteUseCaseMock,
            $this->adicionarClienteUseCaseMock,
            $this->obterClientePorIdUseCaseMock,
            $this->editarClienteUseCaseMock,
            $this->deletarClienteUseCaseMock
        );
    }

    public function testGetAllClientes() {
        $clientesSimulados = [
            ['id' => 1, 'nome' => 'Cliente 1'],
            ['id' => 2, 'nome' => 'Cliente 2']
        ];
        $this->listarClienteUseCaseMock->expects($this->once())
                                        ->method('execute')
                                        ->willReturn($clientesSimulados);
        ob_start();
        $this->clienteResource->getAllClientes();
        $output = ob_get_clean();

        $this->assertEquals(json_encode($clientesSimulados), $output);
    }

    public function testAddCliente() {
        $clienteData = [
            'nome' => 'Novo Cliente',
            'cpf' => '12345678900',
            'rg' => '1234567',
            'data_nascimento' => '1990-01-01',
            'telefone' => '123456789',
            'enderecos' => [
                [
                    'cep' => '12345-678',
                    'numero' => '123',
                    'logradouro' => 'Rua A',
                    'bairro' => 'Centro',
                    'localidade' => 'Cidade',
                    'uf' => 'UF'
                ]
            ]
        ];
        $this->adicionarClienteUseCaseMock->expects($this->once())
                                           ->method('execute')
                                           ->with($clienteData);
        ob_start();
        $this->clienteResource->addCliente($clienteData);
        $output = ob_get_clean();

        $this->assertEquals(http_response_code(), 201);
    }

    public function testGetClienteById() {
        $clienteId = 1;
        $clienteSimulado = ['id' => $clienteId, 'nome' => 'Cliente 1'];
        $this->obterClientePorIdUseCaseMock->expects($this->once())
                                            ->method('execute')
                                            ->with($clienteId)
                                            ->willReturn($clienteSimulado);
        ob_start();
        $this->clienteResource->getClienteById($clienteId);
        $output = ob_get_clean();

        $this->assertEquals(json_encode($clienteSimulado), $output);
    }

    public function testUpdateCliente() {
        $clienteId = 1;
        $clienteData = [
            'nome' => 'Novo Nome',
            'cpf' => '12345678900',
            'rg' => '1234567',
            'data_nascimento' => '1990-01-01',
            'telefone' => '123456789',
            'enderecos' => [
                [
                    'cep' => '12345-678',
                    'numero' => '123',
                    'logradouro' => 'Rua A',
                    'bairro' => 'Centro',
                    'localidade' => 'Cidade',
                    'uf' => 'UF'
                ]
            ]
        ];
        $this->editarClienteUseCaseMock->expects($this->once())
                                        ->method('execute')
                                        ->with($clienteId, $clienteData);
        ob_start();
        $this->clienteResource->updateCliente($clienteId, $clienteData);
        $output = ob_get_clean();

        $this->assertEquals(http_response_code(), 200);
    }

    public function testRemoveCliente() {
        $clienteId = 1;
        $this->deletarClienteUseCaseMock->expects($this->once())
                                         ->method('execute')
                                         ->with($clienteId);
        ob_start();
        $this->clienteResource->removeCliente($clienteId);
        $output = ob_get_clean();

        $this->assertEquals(http_response_code(), 204);
    }
}

