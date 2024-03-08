<?php
    
    class Cliente
    {
        private $id;
        private $nome;
        private $cpf;
        private $rg;
        private $dataNascimento;
        private $telefone;
        private $enderecos;

        public function __construct($nome, $cpf, $rg, $dataNascimento, $telefone, $enderecos = [])
        {
            $this->nome = $nome;
            $this->cpf = $cpf;
            $this->rg = $rg;
            $this->dataNascimento = $dataNascimento;
            $this->telefone = $telefone;
            $this->enderecos = $enderecos;
        }
    
        public function getId()
        {
            return $this->id;
        }
    
        public function setId($id)
        {
            $this->id = $id;
        }
    
        public function getNome()
        {
            return $this->nome;
        }
    
        public function setNome($nome)
        {
            $this->nome = $nome;
        }
    
        public function getCpf()
        {
            return $this->cpf;
        }
    
        public function setCpf($cpf)
        {
            $this->cpf = $cpf;
        }

        public function getRg()
        {
            return $this->rg;
        }

        public function setRg($rg)
        {
            $this->rg = $rg;
        }

        public function getDataNascimento()
        {
            return $this->dataNascimento;
        }

        public function setDataNascimento($dataNascimento)
        {
            $this->dataNascimento = $dataNascimento;
        }

        public function getTelefone()
        {
            return $this->telefone;
        }

        public function setTelefone($telefone)
        {
            $this->telefone = $telefone;
        }

        public function getEnderecos()
        {
            return $this->enderecos;
        }

        public function setEnderecos($enderecos)
        {
            $this->enderecos[] = $enderecos;
        }
    }
