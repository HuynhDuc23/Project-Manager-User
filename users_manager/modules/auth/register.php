<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}
layout('header-login');
$msg = '';

// xu ly dang ky
if (isPost()) {
  $body = getBody();
  $errors = [];
  // validate fullname : required , >= 5 ki tu
  if (empty(trim($body['fullname']))) {
    $errors['fullname']['required'] = 'Tên không được để trống';
  } else {
    if (strlen($body['fullname']) < 5) {
      $errors['fullname']['minlength'] = 'Tên phải có ít nhất 5 ký tự';
    }
  }
  // validate phone : required , dinh dang so dien thoai
  if (empty(trim($body['phone']))) {
    $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập';
  } else {
    if (!isPhone(trim($body['phone']))) {
      $errors['phone']['phone'] = 'Số điện thoại không đúng đ��nh dạng số điện thoại';
    }
  }
  // validate email : required , dinh dang email
  if (empty(trim($body['email']))) {
    $errors['email']['required'] = 'Email bắt buộc phải nhập';
  } else {
    if (!isEmail(trim($body['email']))) {
      $errors['email']['email'] = 'Email không đúng đ��nh dạng';
    } else {
      // query
      $email = trim($body['email']);
      $query = "SELECT id  FROM todolist_user.users WHERE email = '$email'";
      if (getRows($query) > 0) {
        $errors['email']['unique'] = 'Email đã tồn tại';
      }
    }
  }
  // validation pass : required , >= 8 
  if (empty(trim($body['password']))) {
    $errors['password']['required'] = 'Mật khẩu bắt buộc phải nhập';
  } else {
    if (trim(strlen($body['password'])) < 8) {
      $errors['password']['minlength'] = 'Mật khẩu phải có ít nhất 8 ký tự';
    }
  }
  // validation confirm pass : required, match pass
  if (empty(trim($body['confirm_password']))) {
    $errors['confirm_password']['required'] = 'Bắt buộc phải nhập lại mật khẩu';
  } else {
    if (trim($body['confirm_password']) != trim($body['password'])) {
      $errors['confirm_password']['match'] = 'Mật khẩu phải trùng khớp';
    }
  }
  if (empty($errors)) {
    setFlashData('msg', 'Register Sucessfully');
    $msg =  getFlashData('msg');
  } else {
    // co loi xay ra
    setFlashData('msg', 'Vui Lòng Kiểm Tra Dữ Liệu Nhập Vào ');
    $msg =  getFlashData('msg');
    //$msg = 'Vui Long Nhap Lai Thong Tin';
  }
}

?>

<div class="container h-100">
  <div class="d-flex justify-content-center h-100">

    <div class="user_card">

      <div class="d-flex justify-content-center form_container">

        <form action="?module=auth&action=register" class="mt-top" method="post">

          <?php
          if (!empty($msg)) {
            getMsg($msg, 'danger');
          }
          ?>
          <div class="input-group mb-1">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
            </div>
            <input type="text" name="fullname" class="form-control input_user" value="" placeholder="Họ Tên...">
          </div>
          <div class="input-group mb-1">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
            </div>
            <input type="number" name="phone" class="form-control input_pass" value="" placeholder="Điện Thoại...">
          </div>
          <div class="input-group mb-1">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
            </div>
            <input type="email" name="email" class="form-control input_pass" value="" placeholder="Email...">
          </div>
          <div class="input-group mb-1">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
            </div>
            <input type="password" name="password" class="form-control input_pass" value="" placeholder="Mật Khẩu...">
          </div>
          <div class="input-group mb-1">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
            </div>
            <input type="password" name="confirm_password" class="form-control input_pass" value="" placeholder="Nhập Lại Mật Khẩu...">
          </div>
          <div class="d-flex justify-content-center mt-2 login_container">
            <button type="submit" name="button" value="submit" class="btn login_btn">Register</button>
          </div>
        </form>
      </div>

      <div class="mt-6">
        <div class="d-flex justify-content-center links">
          Don't have an account? <a href="?module=auth&action=login" class="ml-2">Login</a>
        </div>

      </div>
    </div>
  </div>
</div>
<?php
layout('footer-login');
