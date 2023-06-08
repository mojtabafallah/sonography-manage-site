<?php

function insert($tableName, $data)
{
    global $conn;
    $fields = array_keys($data);
    $values = array_values($data);

    $fields = implode(', ', $fields);

    foreach ($values as $key => $value) {
        $values[$key] = "'" . $value . "'";
    }

    $values = implode(', ', $values);
    $sql = "INSERT INTO {$tableName} ({$fields}) VALUES ({$values})";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    if ($result === true) {
        return true;
    } else {
        return false;
    }
}