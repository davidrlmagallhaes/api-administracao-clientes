<?php

require_once 'src/configs/dbConfiguration.php';
require_once 'src/entrypoints/domain/entities/Cliente.php';
require_once 'src/entrypoints/domain/entities/Endereco.php';

class ClienteDAO
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllClientes()
    {
        $stmt = $this->pdo->prepare("SELECT
                                        cliente.id, cliente.nome, cliente.cpf,
                                        cliente.rg, cliente.data_nascimento,
                                        cliente.telefone, endereco.id as endereco_id,
                                        endereco.cep, endereco.numero, endereco.logradouro,
                                        endereco.complemento, endereco.bairro,
                                        endereco.localidade, endereco.uf
                                    FROM cliente
                                    LEFT JOIN endereco ON cliente.id = endereco.cliente_id");
        $stmt->execute();
    
        $clientesData = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clienteId = $row['id'];
    
            if (!isset($clientesData[$clienteId])) {
                $clientesData[$clienteId] = [
                    'id' => $clienteId,
                    'nome' => $row['nome'],
                    'cpf' => $row['cpf'],
                    'rg' => $row['rg'],
                    'data_nascimento' => $row['data_nascimento'],
                    'telefone' => $row['telefone'],
                    'enderecos' => []
                ];
            }

            if ($row['endereco_id']) {
                $clientesData[$clienteId]['enderecos'][] = [
                    'id' => $row['endereco_id'],
                    'cep' => $row['cep'],
                    'numero' => $row['numero'],
                    'logradouro' => $row['logradouro'],
                    'complemento' => $row['complemento'],
                    'bairro' => $row['bairro'],
                    'localidade' => $row['localidade'],
                    'uf' => $row['uf']
                ];
            }
        }
    
        return array_values($clientesData);
    }

    public function getClienteById($id)
    {
        $stmt = $this->pdo->prepare("SELECT
                                        cliente.id, cliente.nome, cliente.cpf,
                                        cliente.rg, cliente.data_nascimento, cliente.telefone,
                                        endereco.id as endereco_id, endereco.cep,
                                        endereco.numero, endereco.logradouro,
                                        endereco.complemento, endereco.bairro,
                                        endereco.localidade, endereco.uf
                                      FROM cliente
                                      LEFT JOIN endereco ON cliente.id = endereco.cliente_id
                                      WHERE cliente.id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    
        $clienteData = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!$clienteData) {
                $clienteData = [
                    'id' => $row['id'],
                    'nome' => $row['nome'],
                    'cpf' => $row['cpf'],
                    'rg' => $row['rg'],
                    'data_nascimento' => $row['data_nascimento'],
                    'telefone' => $row['telefone'],
                    'enderecos' => [],
                ];
            }
    
            if ($row['endereco_id']) {
                $endereco = [
                    'id' => $row['endereco_id'],
                    'cep' => $row['cep'],
                    'numero' => $row['numero'],
                    'logradouro' => $row['logradouro'],
                    'complemento' => $row['complemento'],
                    'bairro' => $row['bairro'],
                    'localidade' => $row['localidade'],
                    'uf' => $row['uf']
                ];
                $clienteData['enderecos'][] = $endereco;
            }
        }
    
        return $clienteData;
    }
    

    public function addCliente(Cliente $cliente)
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("INSERT INTO cliente (nome, cpf, rg, data_nascimento, telefone)
                                         VALUES (:nome, :cpf, :rg, :data_nascimento, :telefone)");
    
            $stmt->bindValue(':nome', $cliente->getNome());
            $stmt->bindValue(':cpf', $cliente->getCpf());
            $stmt->bindValue(':rg', $cliente->getRg());
            $stmt->bindValue(':data_nascimento', $cliente->getDataNascimento());
            $stmt->bindValue(':telefone', $cliente->getTelefone());
    
            $stmt->execute();
    
            $clienteId = $this->pdo->lastInsertId();

            // Inserir endereços
            foreach ($cliente->getEnderecos() as $endereco) {
                $this->insertEndereco($endereco, $clienteId);
            }

            $this->pdo->commit();

            return $clienteId;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    public function insertEndereco(Endereco $endereco, $clienteId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO endereco
                                        (cep, numero, logradouro, complemento, bairro, localidade, uf, cliente_id)
                                     VALUES
                                        (:cep, :numero, :logradouro, :complemento, :bairro, :localidade, :uf, :cliente_id)");
    
        $stmt->bindValue(':cep', $endereco->getCep());
        $stmt->bindValue(':numero', $endereco->getNumero());
        $stmt->bindValue(':logradouro', $endereco->getLogradouro());
        $stmt->bindValue(':complemento', $endereco->getComplemento());
        $stmt->bindValue(':bairro', $endereco->getBairro());
        $stmt->bindValue(':localidade', $endereco->getLocalidade());
        $stmt->bindValue(':uf', $endereco->getUf());
        $stmt->bindValue(':cliente_id', $clienteId);
    
        $stmt->execute();
    }

    public function updateCliente($id, Cliente $cliente)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE
                                            cliente
                                        SET
                                            nome=:nome, cpf=:cpf, rg=:rg,
                                            data_nascimento=:data_nascimento, telefone=:telefone
                                        WHERE id = :id");
            $stmt->bindValue(':nome', $cliente->getNome());
            $stmt->bindValue(':cpf', $cliente->getCpf());
            $stmt->bindValue(':rg', $cliente->getRg());
            $stmt->bindValue(':data_nascimento', $cliente->getDataNascimento());
            $stmt->bindValue(':telefone', $cliente->getTelefone());
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $updatedCliente = $this->getClienteById($id);
            return $updatedCliente;
        } catch (PDOException $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    public function updateEndereco($id, Endereco $endereco)
    {
        $stmt = $this->pdo->prepare("UPDATE
                                        endereco
                                     SET
                                        cep=:cep, numero=:numero, logradouro=:logradouro,
                                        complemento=:complemento, bairro=:bairro, localidade=:localidade, uf=:uf
                                     WHERE id = :id");

        $stmt->bindValue(':cep', $endereco->getCep());
        $stmt->bindValue(':numero', $endereco->getNumero());
        $stmt->bindValue(':logradouro', $endereco->getLogradouro());
        $stmt->bindValue(':complemento', $endereco->getComplemento());
        $stmt->bindValue(':bairro', $endereco->getBairro());
        $stmt->bindValue(':localidade', $endereco->getLocalidade());
        $stmt->bindValue(':uf', $endereco->getUf());
        $stmt->bindValue(':id', $id);

        $stmt->execute();
    }

    public function removeCliente($id)
    {
        $this->removeEndereco($id);
        $stmt = $this->pdo->prepare("DELETE FROM cliente WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
    public function removeEndereco($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM endereco WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
}
