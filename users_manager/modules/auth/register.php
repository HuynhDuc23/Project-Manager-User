<?php
if (!defined('_INCODE')) {
  die("Access denied...");
}
layout('header-login');

?>
<div class="container h-100">
  <div class="d-flex justify-content-center h-100">
    <div class="user_card">
      <div class="d-flex justify-content-center">
        <div class="brand_logo_container">
          <img src="https://cdn.freebiesupply.com/logos/large/2x/pinterest-circle-logo-png-transparent.png" class="brand_logo" alt="Logo">
        </div>
      </div>
      <div class="d-flex justify-content-center form_container">
        <form>
          <div class="input-group mb-3">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
            </div>
            <input type="text" name="" class="form-control input_user" value="" placeholder="Họ Tên...">
          </div>
          <div class="input-group mb-2">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></span>
            </div>
            <input type="number" name="" class="form-control input_pass" value="" placeholder="Điện Thoại...">
          </div>
          <div class="input-group mb-2">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
            </div>
            <input type="email" name="" class="form-control input_pass" value="" placeholder="Email...">
          </div>
          <div class="input-group mb-2">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
            </div>
            <input type="password" name="" class="form-control input_pass" value="" placeholder="Mật Khẩu...">
          </div>
          <div class="input-group mb-2">
            <div class="input-group-append">
              <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
            </div>
            <input type="password" name="" class="form-control input_pass" value="" placeholder="Nhập Lại Mật Khẩu...">
          </div>
          <!-- <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="customControlInline">
              <label class="custom-control-label" for="customControlInline">Remember me</label>
            </div>
          </div> -->
          <div class="d-flex justify-content-center mt-3 login_container">
            <button type="button" name="button" class="btn login_btn">Login</button>
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
