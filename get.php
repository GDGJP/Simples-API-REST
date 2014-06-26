<?php

$sql = sprintf('SELECT * FROM %s', $table);

if ($id) {
    if (! $parent) {
        $sql .= ' WHERE id = :id';
        $sth = $db->prepare($sql);
        $sth->execute([':id' => $id]);
    
        success($sth->fetch(PDO::FETCH_ASSOC));
    }
    
    $sql = sprintf('SELECT %s.* FROM %s', $parent, $table);
    $sql .= relation($table, $parent);
    $sql .= sprintf(' WHERE %s.id = :id', $table);
    
    $sth = $db->prepare($sql);
    $sth->execute([':id' => $id]);
    
    success($sth->fetchAll(PDO::FETCH_ASSOC));
}

$sth = $db->prepare($sql);
$sth->execute();

success($sth->fetchAll(PDO::FETCH_ASSOC));