<?php

ini_set('display_errors', 1);
ini_set('html_errors', 1);
ini_set("xdebug.default_enable", 1);

$db = [
    'host' => '127.0.0.1',
    'db' => 'la_bonne_rue',
    'port' => 3306,
    'username' => 'root',
    'password' => 'root',
];

try {
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['db'] . ';port=' . $db['port'], $db['username'], $db['password'] );
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
    exit;
}