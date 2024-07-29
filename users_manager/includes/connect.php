<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}

try {
  if (class_exists('PDO')) {
    $dsn = _DRIVER . ':dbname' . _DB . 'host=' . _HOST;
    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // day loi vao ngoai le khi truy van
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ];
    $conn = new PDO($dsn, _USER, _PASS, $options);

    //echo "Sucessfully connected";
  }
} catch (Exception $ex) {
  echo "Connection failed: " . $ex->getMessage();
  require_once 'modules/errors/database.php'; // import error
  die();
}
