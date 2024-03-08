SET NAMES 'utf8';
SET CHARACTER SET utf8;

CREATE DATABASE IF NOT EXISTS administracao_cliente;
USE administracao_cliente;

CREATE TABLE IF NOT EXISTS cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL,
    rg VARCHAR(20) NOT NULL,
    data_nascimento DATE NOT NULL,
    telefone VARCHAR(20) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS endereco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cep VARCHAR(10) NOT NULL,
    numero VARCHAR(10) NOT NULL,
    logradouro VARCHAR(100) NOT NULL,
    complemento VARCHAR(100),
    bairro VARCHAR(100) NOT NULL,
    localidade VARCHAR(100) NOT NULL,
    uf VARCHAR(2) NOT NULL,
    cliente_id INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO administracao_cliente.cliente
    ( nome, cpf, rg, data_nascimento, telefone)
VALUES
    ( 'Anna Paula Magalhães', '78945612300', '2039041DF', '1986-01-01', '6199999999'),
    ( 'Samuel Barros', '12345678900', '1234567DF', '1953-12-01', '6199999988')
;

INSERT INTO administracao_cliente.endereco
    (cep, numero, logradouro, complemento, bairro, localidade, uf, cliente_id)
VALUES
    ('70658251', '203', 'SHCES Quadra 1205 Bloco A', 'Apto', 'Cruzeiro Novo', 'Brasília', 'DF', 1),
    ('72025530', '401', 'QSF 3', 'Casa', 'Taguatinga Sul', 'Brasília', 'DF', 2),
    ('72025570', '204', 'QSF 7', 'Casa', 'Taguatinga Sul', 'Brasília', 'DF', 2);

INSERT INTO usuario (nome, email, senha) VALUES 
('JOÃO MAGALHÃES', 'jslmagalhaes@vintres.com.br', '$2y$10$4Wb24c5Jwv3M.TSLjOFA3eENvSErM91H7pM0JyjIwzF/FBUU9k7vW'), --2015
('ELISA MAGALHÃES', 'eslmagalhaes@vintres.com.br', '$2y$10$4Wb24c5Jwv3M.TSLjOFA3eENvSErM91H7pM0JyjIwzF/FBUU9k7vW'), --2018
('DAVID MAGALHÃES', 'drlmagalhaes@vintres.com.br', '$2y$10$4Wb24c5Jwv3M.TSLjOFA3eENvSErM91H7pM0JyjIwzF/FBUU9k7vW'); --1983
