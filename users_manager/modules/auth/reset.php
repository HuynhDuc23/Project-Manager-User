<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}
// code chức năng reset mật khẩu
layout('header-login');
$errors = [];
$token = getBody()['token'];
if (!empty($token)) {
  // query
  $tokenQuery = firstRaw("SELECT id , fullname ,email   FROM todolist_user.users WHERE forget_token = '$token'");
  if (!empty($tokenQuery)) {
    $userId = $tokenQuery['id'];
    // tao token reset mật khẩu
    if (isPost()) {
      $body = getBody();
      $errors = []; // Mảng lưu trữ các lỗi
      if (empty($body['password'])) {
        $errors['password']['required'] = 'Mật khẩu không được để trống';
      } else {
        if (strlen(trim($body['password'])) < 6) {
          $errors['password']['min'] = 'Mật khẩu không được nhỏ hơn 6 kí tự';
        }
      }
      if (empty($body['confirm_password'])) {
        $errors['confirm_password']['required'] = 'Vui lòng nhập mật khẩu';
      } else {
        if ((trim($body['password']) != trim($body['confirm_password']))) {
          $errors['confirm_password']['match'] = 'Mật khẩu không khớp';
        }
      }
      if (empty($errors)) {
        // call database để kiểm tra
        $passwordHash = password_hash($body['password'], PASSWORD_DEFAULT);
        $dataUpdate = [
          'password' => $passwordHash,
          'forget_token' => null,
          'createat_datetime' => date('Y-m-d H:i:s')
        ];
        $updateStatus = update('todolist_user.users', $dataUpdate, "id=$userId");
        if ($updateStatus) {
          setFlashData('msg', 'Mật khẩu đã được cập nhật thành công');
          redirect('?module=auth&action=login');
        } else {
          setFlashData('msg', 'Đã xảy ra lỗi khi cập nhật mật khẩu');
          redirect('?module=auth&action=reset&token=' . $token); // load lai trang đặt lại mật khẩu
        }
      } else {
        setFlashData('msg', 'Vui lòng kiểm tra dữ liệu nhập vào');
        setFlashData('errors', $errors);
        redirect('?module=auth&action=reset&token=' . $token); // load lai trang đặt lại mật khẩu
      }
    }
    $msg = getFlashData('msg');
    $errors = getFlashData('errors');
?>
    <div class="container h-100">
      <div class="d-flex justify-content-center h-100">
        <div class="user_card">
          <h3 class="text-center text-uppercase">Đặt lại mật khẩu</h3>
          <?php echo (!empty($msg)) ? getMsg($msg) : null ?>

          <div class="d-flex justify-content-center form_container">

            <form action="?module=auth&action=reset" method="post">
              <div class="input-group mb-2">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
                </div>
                <input type="password" name="password" class="form-control input_pass" value="" placeholder="password">
              </div>
              <?php echo get_error($errors, 'password', '<div class=error>', '</div>') ?>
              <div class="input-group mb-2">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
                </div>
                <input type="password" name="confirm_password" class="form-control input_pass" value="" placeholder="password">
              </div>
              <?php echo get_error($errors, 'confirm_password', '<div class=error>', '</div>') ?>
              <div class="d-flex justify-content-center mt-3 login_container">
                <button type="submit" name="button" class="btn login_btn" value="submit">Reset</button>
              </div>
              <input type="hidden" name="token" value="<?php echo $token ?>">
            </form>
          </div>

          <div class="mt-4">
            <div class="d-flex justify-content-center links">
              Don't have an account? <a href="?module=auth&action=login" class="ml-2">Đăng Nhập</a>
            </div>
            <div class="d-flex justify-content-center links">
              <a href="?module=auth&action=register">Đăng Ký?</a>
            </div>
          </div>
        </div>
      </div>
    </div>

<?php
  } else {
    setFlashData('msg', 'Token không hợp lệ');
  }
} else {
  setFlashData('msg', 'Đường dẫn hết hạn hoặc không chính xác');
}



?>
<?php
layout('footer-login');
?>