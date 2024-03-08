<?php

require_once 'src/entrypoints/domain/getways/ClienteGetway.php';

class ClienteService
{
    private $gateway;

    public function __construct(ClienteGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function getAllClientes()
    {
        return $this->gateway->getAll();
    }

    public function getClienteById($id)
    {
        return $this->gateway->getById($id);
    }

    public function addCliente($data)
    {
        return $this->gateway->save($data);
    }

    public function updateCliente($id, $data)
    {        
        return $this->gateway->update($id, $data);
    }

    public function removeCliente($id)
    {
        return $this->gateway->delete($id);
    }
}
