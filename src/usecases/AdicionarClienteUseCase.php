<?php

class AdicionarClienteUseCase {
    private $service;

    public function __construct(ClienteService $service) {
        $this->service = $service;
    }

    public function execute(array $data) {
        return $this->service->addCliente($data);
    }
}

