<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}
// ham gan session
function setSession($key, $value)
{
  // dung ham session_id : check ben client co ton tai session_id : luu o cookie
  if (!empty(session_id())) {
    $_SESSION[$key] = $value;
    return true;
  }
  return false;
}
// ham doc session
function getSession($key = '')
{
  if (empty($key)) {
    return $_SESSION;
  } else {
    if (isset($_SESSION[$key])) {
      return $_SESSION[$key];
    }
  }
  return false;
}
// ham xoa session
function removeSession($key = '')
{
  if (empty($key)) {
    session_destroy();
    // Chức năng session_destroy() trong PHP được sử dụng để chấm dứt một phiên và xóa tất cả dữ liệu phiên liên quan đến phiên đó.
    return true;
  } else {
    if (isset($_SESSION[$key])) {
      unset($_SESSION[$key]);
      return true;
    }
  }
  return false;
}
// ham gan flase data 
// 1 loai session ten : flashdata
function setFlashData($key, $value)
{
  $key = 'flash_' . $key;
  setSession($key, $value);
}
function getFlashData($key)
{
  $key = 'flash_' . $key;
  $data = getSession($key);
  removeSession($key);
  return $data;
}
