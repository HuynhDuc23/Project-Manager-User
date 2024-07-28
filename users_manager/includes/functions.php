<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}
function layout($layoutName = 'header')
{
  if (file_exists(_WEB_PATH_TEMPLATE . '/layouts/' . $layoutName . '.php')) {
    require_once _WEB_PATH_TEMPLATE . '/layouts/' . $layoutName . '.php';
  }
}
