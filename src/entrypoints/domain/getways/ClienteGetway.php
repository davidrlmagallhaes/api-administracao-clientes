<?php

require_once 'src/entrypoints/infrastructures/dao/ClienteDAO.php';
require_once 'src/entrypoints/domain/repositories/ClienteRepository.php';

class ClienteGateway implements ClienteRepository {
    private $clienteDAO;

    public function __construct(PDO $pdo) {
        $this->clienteDAO = new ClienteDAO($pdo);
    }

    public function getAll() {
        return $this->clienteDAO->getAllClientes();
    }

    public function getById($id) {
        return $this->clienteDAO->getClienteById($id);
    }

    public function save($data) {
        $cliente = new Cliente(
            $data['nome'],
            $data['cpf'],
            $data['rg'],
            $data['data_nascimento'],
            $data['telefone']
        );

        $clienteId = $this->clienteDAO->addCliente($cliente);

        if (isset($data['enderecos']) && is_array($data['enderecos'])) {
            foreach ($data['enderecos'] as $enderecoData) {
                $endereco = new Endereco(
                    $enderecoData['cep'],
                    $enderecoData['numero'],
                    $enderecoData['logradouro'],
                    $enderecoData['complemento'],
                    $enderecoData['bairro'],
                    $enderecoData['localidade'],
                    $enderecoData['uf'],
                    $clienteId
                );

                $this->clienteDAO->insertEndereco($endereco, $clienteId);
            }
        }

        return $clienteId;
    }

    public function update($id, $data) {
        $cliente = new Cliente(
            $data['nome'],
            $data['cpf'],
            $data['rg'],
            $data['data_nascimento'],
            $data['telefone']
        );

        $this->clienteDAO->updateCliente($id, $cliente);

        $updatedCliente = $this->clienteDAO->getClienteById($id);

        if (isset($data['enderecos']) && is_array($data['enderecos'])) {
            foreach ($data['enderecos'] as $enderecoData) {
                $endereco = new Endereco(
                    $enderecoData['cep'],
                    $enderecoData['numero'],
                    $enderecoData['logradouro'],
                    $enderecoData['complemento'],
                    $enderecoData['bairro'],
                    $enderecoData['localidade'],
                    $enderecoData['uf'],
                    $id // Usando o ID do cliente para atualizar o endereço
                );

                if (isset($enderecoData['id'])) {
                    $this->clienteDAO->updateEndereco($enderecoData['id'], $endereco);
                } else {
                    $this->clienteDAO->insertEndereco($endereco);
                }
            }
        }
        return $updatedCliente;
    }

    public function delete($id) {
        $this->clienteDAO->removeCliente($id);
    }
}
