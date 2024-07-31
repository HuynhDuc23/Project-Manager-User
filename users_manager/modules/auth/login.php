<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}
layout('header-login');

$msg = getFlashData('msg');

// kiem tra trang thai dang nhap



// Kiểm tra trạng thái đăng nhập
$checkLogin = false;
if (getSession('loginToken')) {
  $tokenLogin = getSession('loginToken');
  $queryToken = firstRaw("SELECT userId FROM login_token WHERE  token ='$tokenLogin'");
  if (!empty($queryToken)) {
    $checkLogin = true;
  } else {
    removeSession('loginToken');
  }
}
if ($checkLogin) {
  redirect('?module=users');
}

// xử lý trạng thái đăng nhâp;
if (isPost()) {
  $body = getBody();
  if (!empty(trim($body['email'])) && !empty(trim($body['password']))) {
    // kiểm tra đăng nhập
    $email = $body['email'];
    $password = $body['password'];
    // $ truy vấn database
    $useQuery = firstRaw("SELECT id , password FROM todolist_user.users WHERE email='$email'");
    if (!empty($useQuery)) {
      $passwordHash = $useQuery['password'];
      $userId = $useQuery['id'];
      if (password_verify($password, $passwordHash)) {
        // tao token login
        $tokenLogin = sha1(uniqid(), time());
        // insert data vao login token
        $dataToken =
          [
            'userId' => $userId,
            'token' => $tokenLogin,
            'createdAt' => date('Y-m-d H:i:s')
          ];
        $insertTokenStatus = insert('login_token', $dataToken);
        if ($insertTokenStatus) {
          // lưu login token vào session
          setSession('tokenLogin', $tokenLogin);
          // chuyển hướng
          redirect('?module=users');
        } else {
          setFlashData('msg', 'Lỗi hệ thống không thể đăng nhập vào hệ thống');
          redirect('?module=auth&action=login');
        }
      } else {
        setFlashData('msg', 'Sai mật khẩu , Vui Lòng Thử Lại Nhé');
        redirect('?module=auth&action=login');
      }
    }
  } else {
    setFlashData('msg', 'Vui lòng kiểm tra lại tài khoản và mật khẩu');
  }
}

?>
<div class="container h-100">
  <div class="d-flex justify-content-center h-100">
    <div class="user_card">
      <h3 class="text-center text-uppercase">Đăng Nhập</h3>
      <?php echo (!empty($msg)) ? getMsg($msg) : null ?>

      <div class="d-flex justify-content-center form_container">

        <form action="?module=auth&action=forgot" method="post">
          <div class="input-group mb-3">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
            </div>
            <input type="text" name="email" class="form-control input_user" value="" placeholder="email">
          </div>
          <div class="input-group mb-2">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
            </div>
            <input type="password" name="password" class="form-control input_pass" value="" placeholder="password">
          </div>
          <!-- <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customControlInline">
              <label class="custom-control-label" for="customControlInline">Remember me</label>
            </div>
          </div> -->
          <div class="d-flex justify-content-center mt-3 login_container">
            <button type="submit" name="button" class="btn login_btn" value="submit">Login</button>
          </div>
        </form>
      </div>

      <div class="mt-4">
        <div class="d-flex justify-content-center links">
          Don't have an account? <a href="?module=auth&action=register" class="ml-2">Sign Up</a>
        </div>
        <div class="d-flex justify-content-center links">
          <a href="?module=auth&action=forgot">Forgot your password?</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
layout('footer-login');
?>