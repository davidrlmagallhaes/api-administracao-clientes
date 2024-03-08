<?php

class DeletarClienteUseCase {
    private $service;

    public function __construct(ClienteService $service) {
        $this->service = $service;
    }

    public function execute($id) {
        return $this->service->removeCliente($id);
    }
}
