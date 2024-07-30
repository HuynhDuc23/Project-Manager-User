<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}

layout('header-login');

$token = getBody()['token'];
if (!empty($token)) {
  // kiem tra truy van token voi database
  $tokenQuery = firstRaw("SELECT id , email, fullname FROM todolist_user.users WHERE active_token = '$token'");
  print_r($tokenQuery);
  if (!empty($tokenQuery)) {
    $userId = $tokenQuery['id'];
    $dataUpdate = [
      'status' => 1,
      'active_token' => null
    ];
    $updateStatus = update('todolist_user.users', $dataUpdate, "id = $userId");
    if ($updateStatus) {
      setFlashData('msg', 'Kích hoạt tài khoản thành công , đến trang đăng nhập để vào hệ thống');
      // gửi mail khi đăng kí thành công
      $loginLink = _WEB_HOST_ROOT . '?module=auth&action=login';
      $subject = 'Chúc mừng bạn đã đăng ký thành công';
      $content = 'Chúc mừng ' . $tokenQuery['fullname'] . 'Vui lòng click link sau để chuyển sang đăng nhập';
      $content .= '' . $loginLink . '';
      sendMail($tokenQuery['email'], $subject, $content);
    } else {
      setFlashData('msg', 'Kích hoạt không thành công vui lòng liên hệ quản trị viên');
    }
    redirect('?module=auth&action=login');
  } else {
    getMsg('Liên kết không tồn tại hoặc hết hạn ', 'danger');
  }
}
