<?php

require_once 'configs/dbConfiguration.php';
require_once 'entriponts/domain/entities/Usuario.php';

class UsuarioDao
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createUser(Usuario $usuario)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindValue(':username', $usuario->getNome());
        $stmt->bindValue(':email', $usuario->getEmail());
        $stmt->bindValue(':password', $usuario->getSenha());
        $stmt->execute();
        return $this->pdo->lastInsertId();
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
            return null;
        }

        $usuario = new Usuario($result['nome'], $result['email'], $result['senha']);
        $usuario->setId($result['id']);
        return $usuario;
    }

    public function verifyPassword(Usuario $usuario, $password)
    {
        return $usuario->verificarSenha($password);
    }
}
