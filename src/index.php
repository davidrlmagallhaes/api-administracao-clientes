<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 200 OK');
    exit();
}

require_once 'src/entrypoints/ClienteResource.php';
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

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$segments = explode('/', trim($uri, '/'));


if ($segments[0] === 'login') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $postData = file_get_contents("php://input");
        $data = json_decode($postData, true);
    
        if (isset($data['username']) && isset($data['password'])) {
            $username = $data['username'];
            $password = $data['password'];
    
            // Verifique o nome de usuário e a senha
            if ($username === 'davidrlmagalhaes@vintres.com.br' && $password === '1983') {
                header('HTTP/1.1 200 OK');
                echo 'Login bem-sucedido';
                exit();
            } else {
                header('HTTP/1.1 401 Unauthorized');
                echo 'Credenciais inválidas';
                exit();
            }
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo 'Dados de login ausentes';
            exit();
        }
    }
    exit();
}

if ($segments[0] === 'cliente') {
    if ($method === 'GET') {
        if (isset($segments[1]) && is_numeric($segments[1])) {
            $clienteResource->getClienteById($segments[1]);
        } else {
            $clienteResource->getAllClientes();
        }
    } elseif ($method === 'POST' && isset($segments[1]) && $segments[1] === 'cadastro') {
        $data = json_decode(file_get_contents("php://input"), true);
        $clienteResource->addCliente($data);
    } elseif ($method === 'PUT' && isset($segments[1]) && is_numeric($segments[1])) {
        $id = $segments[1];
        $data = json_decode(file_get_contents("php://input"), true);
        $clienteResource->updateCliente($id, $data);
    } elseif ($method === 'DELETE' && isset($segments[1]) && is_numeric($segments[1])) {
        $clienteResource->removeCliente($segments[1]);
        header('HTTP/1.0 204 No Content');
    }
} else {
    header('HTTP/1.0 404 Not Found');
    echo 'Rota não encontrada';
}

