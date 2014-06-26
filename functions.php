<?php

function response($data, $code) {
    $callback = isset($_GET['callback']) ? filter_var($_GET['callback'], FILTER_SANITIZE_STRING) : '';
    $encoded  = json_encode($data);
    
    if ($callback) {
        header('Content-type: text/javascript');
        printf(';%s(%s);', $callback, $encoded);
        exit;
    }
    
    http_response_code($code);
    header('Content-type: application/json');
    echo $encoded;
    exit;
}

function success($data) {
    response(['status' => 'success', 'data' => $data], 200);
}

function error($message) {
    response(['status' => 'error', 'message' => $message], 500);
}

function parse_params($baseUrl) {
    $path   = parse_url($_SERVER['REQUEST_URI'])['path'];
    $parts  = trim(str_replace($baseUrl, '', $path), '/');
    $params = explode('/', $parts);
        
    if (! count($params)) {
        error('Informe o recurso');
    }
    
    return $params;
}

function relation($table, $parent) {
    $map  = require('map.php');
    $sql  = '';
    $join = ' JOIN %s ON %s';
    
    if (! isset($map[$table][$parent])) {
        error('Recurso não relacionado ou não mapeado');
    }
    
    $relation = $map[$table][$parent];
    
    if (is_array($relation)) {
        foreach ($relation as $key => $value) {
            $sql .= sprintf($join, $key, $value);
        }
    } else {
        $sql .= sprintf($join, $parent, $relation);
    }
    
    return $sql;
}