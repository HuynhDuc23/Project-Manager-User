<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}
// query : insert update , delete
function query($sql, $data = [], $statementStatus = false)
{
  global $conn;
  $query = false;
  try {
    $statement = $conn->prepare($sql);
    if (empty($data)) {
      $query = $statement->execute();
    } else {
      $query = $statement->execute($data);
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
  }
  if ($statementStatus && $query) {
    return $statement;
  }
  return $query;
};
function insert($table, $dataInsert)
{
  $sql = '';
  // get key => array key 
  $keys = array_keys($dataInsert);
  $fieldStr = implode(', ', $keys);
  $valueStr = ':' . implode(', :', $keys);
  $sql = 'INSERT INTO ' . $table . '' . ($fieldStr) . 'VALUES (' . $valueStr . ')';
  return query($sql, $dataInsert);
}
function ($table, $dataUpdate, $condition) {
  $updateStr = '';
  foreach ($dataUpdate as $key => $value) {
    $updateStr .= $key . '= :' . $key . ',';
  }
  $updateStr = rtrim($updateStr, ',');

  if (!empty($condition)) {
    $sql = 'UPDATE ' . $table . 'SET' . $updateStr . 'WHERE ' . $condition;
  } else {
    $sql = 'UPDATE ' . $table . 'SET' . $updateStr;
  }
  return query($sql, $dataUpdate);
};
function delete($table, $condition)
{
  if (!empty($condition)) {
    $sql = 'DELETE FROM ' . $table . 'WHERE ' . $condition;
  } else {
    $sql = 'DELETE FROM ' . $table;
  }
  return query($sql);
}
// lay du lieu tu cau lenh sql
function getRaw($sql)
{
  $statement = query($sql, [], true);
  if (is_object($statement)) {
    $dataFetch = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $dataFetch;
  }
  return false;
}
// lay 1 dong
function firstRaw($sql)
{
  $statement = query($sql, [], true);
  if (is_object($statement)) {
    return $statement->fetch(PDO::FETCH_ASSOC);
  }
  return false;
}
function get($table, $field = '*', $condition = '')
{
  $sql =  'SELECT ' . $field . 'FROM' . $table;
  if (!empty($condition)) {
    $sql .= 'WHERE ' . $condition;
  }
  return getRaw($sql);
}
function first($table, $field = '*', $condition = '')
{
  $sql =  'SELECT ' . $field . 'FROM ' . $table;
  if (!empty($condition)) {
    $sql .= ' WHERE ' . $condition;
  }
  return firstRaw($sql);
}
