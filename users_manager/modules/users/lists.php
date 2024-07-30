<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}
// kiem tra trang thai dang nhap
$checkToken = false;
if (getSession('loginToken')) {
  $tokenLogin = getSession('loginToken');
  $queryToken = firstRaw("SELECT userId FROM login_token WHERE  token ='$tokenLogin'");
  if (!empty($queryToken)) {
    $checkToken = true;
  } else {
    removeSession('loginToken');
    //redirect('?module=auth&action=login');
  }
}
if (!$checkToken) {
  redirect('?module=auth&action=login');
}
