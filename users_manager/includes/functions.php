<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!defined('_INCODE')) {
  die("Access denied...");
}
function layout($layoutName = 'header')
{
  if (file_exists(_WEB_PATH_TEMPLATE . '/layouts/' . $layoutName . '.php')) {
    require_once _WEB_PATH_TEMPLATE . '/layouts/' . $layoutName . '.php';
  }
}
function sendMail($to, $subject, $content)
{
  //Create an instance; passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->SMTPSecure = "ssl";
    $mail->Username   = 'ductrantad23@gmail.com';                     //SMTP username
    $mail->Password   = _SECRET;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    //Recipients
    $mail->setFrom('ductrantad23@gmail.com', 'Mailer');
    $mail->addAddress($to);     //Add a recipient
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $content;
    $mail->CharSet = "UTF-8";


    return $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
function isPost()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    return true;
  }
  return false;
}
function isGet()
{
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    return true;
  }
  return false;
}
// lay gia tri bien GET ,POST
function getBody()
{
  $bodyArr = [];
  if (isGet()) {
    // xu ly chuoi truoc khi hien ra ;
    // return $_GET ;
    // doc key cua mang $_GET
    if (!empty($_GET)) {
      foreach ($_GET as $key => $value) {
        $key = strip_tags($key);
        // loai bo the html
        if (is_array($value)) {
          // check value array -> van chap nhan
          $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
        } else {
          $bodyArr[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }
      }
    }
  }
  if (isPost()) {
    if (!empty($_POST)) { {
        foreach ($_POST as $key => $value) {
          $key = strip_tags($key);
          if (is_array($value)) {
            $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
          } else {
            $bodyArr[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
          }
        }
      }
    }
  }
  return $bodyArr;
}
function isEmail($email)
{
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}
// kiem tra so nguyen
function isNumberInt($number, $range = [])
{

  // $range = [
  // min_rang -> ..
  // max_range ->...
  // 
  //]
  if (!empty($range)) {
    $options = [
      'options' => $range
    ];
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT, $options);
  } else {
    $checkNumber = filter_var($number, FILTER_VALIDATE_INT);
  }
  return $checkNumber;
}
function isNumberFloat($number, $range = [])
{

  // $range = [
  // min_rang -> ..
  // max_range ->...
  // 
  //]
  if (!empty($range)) {
    $options = [
      'options' => $range
    ];
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT, $options);
  } else {
    $checkNumber = filter_var($number, FILTER_VALIDATE_FLOAT);
  }
  return $checkNumber;
}
function isPhone($number)
{
  $checkFirstZero = false;
  if ($number[0] == '0') {
    $checkFirstZero = true;
    $number = substr($number, 1);
  }
  $checkNumberLast = false;
  if (isNumberInt($number) && (strlen($number) == 9)) {
    $checkNumberLast = true;
  }
  if ($checkFirstZero && $checkNumberLast) {
    return true;
  }
  return false;
}
// ham thong bao loi
function getMsg($msg, $type = 'success')
{
  echo "<div class=\"alert alert-$type\">";
  echo $msg;
  echo '</div>';
}
// code chuyern huong trang 
function redirect($path = 'index.php')
{
  header("Location: $path");
  exit;
}
// old data
function oldData($datas, $fieldName, $default = null)
{
  return (!empty($datas[$fieldName])) ? $datas[$fieldName] : $default;
}
// get thong bao loi
function get_error($errors, $fieldName, $beforeHTML, $afterHTML, $default = null)
{
  return (!empty($errors[$fieldName])) ? $beforeHTML . reset($errors[$fieldName]) . $afterHTML : $default;
}
