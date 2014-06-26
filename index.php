<?php
require('functions.php');

$params = parse_params('/io/simple/index.php');
$db     = new PDO('mysql:dbname=orm;host=127.0.0.1', 'root', '123456');
$method = strtolower($_SERVER['REQUEST_METHOD']);
$table  = filter_var($params[0], FILTER_SANITIZE_STRING);
$id     = isset($params[1]) ? (int) $params[1] : 0;
$parent = isset($params[2]) ? filter_var($params[2], FILTER_SANITIZE_STRING) : '';

if (! in_array($method, ['get', 'post', 'put', 'delete'])) {
    error('Método inválido');
}

require $method . '.php';