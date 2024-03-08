<?php

class EditarClienteUseCase {
    private $service;

    public function __construct(ClienteService $service) {
        $this->service = $service;
    }

    public function execute($id, array $data) {
        return $this->service->updateCliente($id,$data);
    }
}
