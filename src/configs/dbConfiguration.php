<?php

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'administracao_cliente');
define('DB_PORT', '3306');
define('DB_USER', 'root');
define('DB_PASS', 'root');
$pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
