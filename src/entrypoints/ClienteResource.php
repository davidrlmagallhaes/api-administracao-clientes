<?php

require_once 'src/services/ClienteService.php';
require_once 'src/usecases/ListarClienteUseCase.php';
require_once 'src/usecases/AdicionarClienteUseCase.php';
require_once 'src/usecases/ObterClientePorIdUseCase.php';
require_once 'src/usecases/EditarClienteUseCase.php';
require_once 'src/usecases/DeletarClienteUseCase.php';


$clienteGateway = new ClienteGateway($pdo);
$clienteService = new ClienteService($clienteGateway);
$listarClienteUseCase = new ListarClienteUseCase($clienteService);
$adicionarClienteUseCase = new AdicionarClienteUseCase($clienteService);
$obterClientePorIdUseCase = new ObterClientePorIdUseCase($clienteService);
$editarClienteUseCase = new EditarClienteUseCase($clienteService);
$deletarClienteUseCase = new DeletarClienteUseCase($clienteService);
$clienteResource = new ClienteResource($listarClienteUseCase, $adicionarClienteUseCase, $obterClientePorIdUseCase
                                        ,$editarClienteUseCase, $deletarClienteUseCase );

class ClienteResource {
    private $listarClienteUseCase;
    private $adicionarClienteUseCase;
    private $obterClientePorIdUseCase;
    private $editarClienteUseCase;
    private $deletarClienteUseCase;

    public function __construct(ListarClienteUseCase $listarClienteUseCase,
                                AdicionarClienteUseCase $adicionarClienteUseCase,
                                ObterClientePorIdUseCase $obterClientePorIdUseCase,
                                EditarClienteUseCase $editarClienteUseCase,
                                DeletarClienteUseCase $deletarClienteUseCase)
    {
        $this->listarClienteUseCase = $listarClienteUseCase;
        $this->adicionarClienteUseCase = $adicionarClienteUseCase;
        $this->obterClientePorIdUseCase = $obterClientePorIdUseCase;
        $this->editarClienteUseCase = $editarClienteUseCase;
        $this->deletarClienteUseCase = $deletarClienteUseCase;
    }

    public function getAllClientes()
    {
        $clientes = $this->listarClienteUseCase->execute();
        header('Content-Type: application/json');
        echo json_encode($clientes);
    }

    public function addCliente($data)
    {
        if (!isset($data['nome'], $data['cpf'], $data['rg'], $data['data_nascimento'], $data['telefone'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Dados do cliente incompletos']);
            return;
        }

        if (empty($data['enderecos'])) {
            http_response_code(400);
            echo json_encode(['message' => 'O cliente deve ter pelo menos um endereço']);
            return;
        }

        foreach ($data['enderecos'] as $endereco) {
            if (!isset($endereco['cep'], $endereco['numero'], $endereco['logradouro'],
                        $endereco['bairro'], $endereco['localidade'], $endereco['uf'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Dados do endereço incompletos']);
                return;
            }
        }

        $this->adicionarClienteUseCase->execute($data);
        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Cliente adicionado com sucesso']);
    }

    public function getClienteById($id)
    {
        $cliente = $this->obterClientePorIdUseCase->execute($id);

        if ($cliente) {
            header('Content-Type: application/json');
            echo json_encode($cliente);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Cliente não encontrado']);
        }
    }

    public function updateCliente($id, $data)
    {
        $cliente = $this->editarClienteUseCase->execute($id, $data);

        if ($cliente) {
            header('Content-Type: application/json');
            echo json_encode($cliente);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Cliente não encontrado']);
        }
    }

    public function removeCliente($id)
    {
        $this->deletarClienteUseCase->execute($id);
        http_response_code(204);
    }
}
                                        


