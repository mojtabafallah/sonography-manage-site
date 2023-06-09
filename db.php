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
        return last("users");
    } else {
        return false;
    }
}

function edit($tableName, $data, $where)
{
    global $conn;
    $sql = "UPDATE {$tableName} set  ";
    foreach ($data as $key => $value) {
        $sql .= "`$key` = '$value',";
    }
    $sql = rtrim($sql, ",");

    $sql .= " where $where";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    if ($result === true) {
        return true;
    } else {
        return false;
    }
}

function deleteDb($tableName, $where){
    global $conn;
    $sql = "delete from {$tableName}  ";
    $sql .= " where $where";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    if ($result === true) {
        return true;
    } else {
        return false;
    }
}


function find($tableName, $where)
{
    global $conn;
    $fields = array_keys($where);
    $values = array_values($where);

    $sql = "SELECT * FROM {$tableName} where $fields[0] = $values[0] ";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    if ($result) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return false;
}

function last($tableName)
{
    global $conn;

    $sql = "SELECT * FROM {$tableName} ORDER BY id DESC LIMIT 1";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();
    if ($result) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    return false;
}