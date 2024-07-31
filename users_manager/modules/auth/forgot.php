<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}
layout('header-login');
$msg = getFlashData('msg');
if (isPost()) {
  $body = getBody();
  if (!empty($body['email'])) {
    $email = $body['email'];
    $queryUser = firstRaw("SELECT id from todolist_user.users where email = '$email'");
    if (!empty($queryUser)) {
      $userId = $queryUser['id'];
      $token = sha1(uniqid() . time());
      $dataUpdate = [
        'forget_token' => $token
      ];
      $updateStatus = update('todolist_user.users', $dataUpdate, 'id=' . $userId);
      $linkReset = _WEB_HOST_ROOT . '?module=auth&action=reset&token=' . $token;
      if ($updateStatus) {
        // send mail
        $subject = 'Yêu cầu khôi phục mật khẩu';
        $content = 'Xin chào.' . $email . ', đã gửi yêu cầu khôi phục mật khẩu tới email của bạn. Nếu bạn không yêu cầu khôi phục mật khẩu này, vui lòng bỏ qua email này. </br>';
        $content = ' Vui lòng click vào đường link sau để khôi phục mật khẩu ';
        $content .= '' . $linkReset . '</br>';
        $content .= 'Trân trọng cảm ơn';
        $statusSendMail = sendMail($email, $subject, $content);
        if ($statusSendMail) {
          setFlashData('msg', 'Vui lòng kiểm tra email để nhận link khôi phục mật khẩu');
        } else {
          setFlashData('msg', 'Lỗi hệ thống, không thể gửi email cho bạn...');
        }
      } else {
        setFlashData('msg', 'Lỗi hệ thống , không thể sử dụng chức năng này...');
      }
    } else {
      setFlashData('msg', 'Email không tồn tại , vui lòng thử lại');
    }
  } else {
    setFlashData('msg', 'Vui lòng nhập Tài Khoản Email');
  }
  redirect('?module=auth&action=forgot');
}

?>

<div class="container h-100">
  <div class="d-flex justify-content-center h-100">
    <div class="user_card">

      <h3 class="text-center text-uppercase">Đặt lại mật khẩu</h3>
      <?php echo (!empty($msg)) ? getMsg($msg) : null ?>
      <div class="d-flex justify-content-center form_container">

        <form action="?module=auth&action=forgot" method="post">
          <div><label for="email">Email</label></div>
          <div class="input-group mb-3">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
            </div>
            <div><input type="text" name="email" class="form-control input_user" value="" placeholder="email" id="email"></div>

          </div>
          <div class="d-flex justify-content-center mt-3 login_container">
            <button type="submit" name="button" class="btn login_btn" value="submit">Submit</button>
          </div>

        </form>

      </div>
      <p class="text-center"><a href="?module=auth&action=login">Đăng Nhập</a></p>
      <p class="text-center"><a href="?module=auth&action=register">Đăng Ký</a></p>
    </div>
  </div>
</div>
<?php
layout('footer-login');
?>