<?php

$data = [];

foreach ($_POST as $key => $value) {
    $data[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

$fields = array_keys($data);
$sql    = "INSERT INTO %s(%s) VALUES(:%s)";
$sql    = sprintf($sql, $table, implode(",", $fields), implode(",:", $fields));

$sth = $db->prepare($sql);
$sth->execute($data);

success(['id' => $db->lastInsertId()]);