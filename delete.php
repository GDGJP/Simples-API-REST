<?php

if (! $id) {
    error('O id deve ser informado');
}

$sql = sprintf("DELETE FROM %s WHERE %s = %d", $table, 'id', $id);

$sth = $db->prepare($sql);
$sth->execute();

success([]);