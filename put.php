<?php

$data = [];
parse_str(file_get_contents("php://input"), $put);

foreach ($put as $key => $value) {
    $data[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

if (! $id) {
    error('O id deve ser informado');
}

$set = "";

if (isset($data['id'])) {
    unset($data['id']);
}

$fields = array_keys($data);

foreach ($fields as $field) {
    $set .= sprintf("%s = :%s, ", $field, $field);
}

$set = substr($set, 0, strlen($set)-2);
$sql = "UPDATE %s SET %s WHERE %s = %d";
$sql = sprintf($sql, $table, $set, 'id', $id);

$sth = $db->prepare($sql);
$sth->execute($data);

success(['id' => $id]);