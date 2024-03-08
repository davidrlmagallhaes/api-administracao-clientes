<?php

class ListarClienteUseCase {
    private $service;

    public function __construct(ClienteService $service) {
        $this->service = $service;
    }

    public function execute(): array {
        return $this->service->getAllClientes();
    }
}
