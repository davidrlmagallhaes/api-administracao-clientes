<?php

    class Endereco
    {
        private $id;
        private $cep;
        private $numero;
        private $logradouro;
        private $complemento;
        private $bairro;
        private $localidade;
        private $uf;
        private $clienteId;

        public function __construct($cep, $numero, $logradouro,
                                    $complemento, $bairro, $localidade, $uf, $clienteId)
        {
            $this->cep = $cep;
            $this->numero = $numero;
            $this->logradouro = $logradouro;
            $this->complemento = $complemento;
            $this->bairro = $bairro;
            $this->localidade = $localidade;
            $this->uf = $uf;
            $this->clienteId = $clienteId;
        }

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;
        }

        public function getCep()
        {
            return $this->cep;
        }

        public function setCep($cep)
        {
            $this->cep = $cep;
        }

        public function getNumero()
        {
            return $this->numero;
        }

        public function setNumero($numero)
        {
            $this->numero = $numero;
        }

        public function getLogradouro()
        {
            return $this->logradouro;
        }

        public function setLogradouro($logradouro)
        {
            $this->logradouro = $logradouro;
        }

        public function getComplemento()
        {
            return $this->complemento;
        }

        public function setComplemento($complemento)
        {
            $this->complemento = $complemento;
        }

        public function getBairro()
        {
            return $this->bairro;
        }

        public function setBairro($bairro)
        {
            $this->bairro = $bairro;
        }

        public function getLocalidade()
        {
            return $this->localidade;
        }

        public function setLocalidade($localidade)
        {
            $this->localidade = $localidade;
        }

        public function getUf()
        {
            return $this->uf;
        }

        public function setUf($uf)
        {
            $this->uf = $uf;
        }

        public function getClienteId()
        {
            return $this->clienteId;
        }

        public function setClienteId($clienteId)
        {
            $this->clienteId = $clienteId;
        }
    }
