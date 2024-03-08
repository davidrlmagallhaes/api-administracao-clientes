<?php

class Usuario
{
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __construct($nome, $email, $senha)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    // Método para verificar se a senha está correta
    public function verificarSenha($senha)
    {
        return password_verify($senha, $this->senha);
    }
}
