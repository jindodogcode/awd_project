<?php
session_start();
require('./utils.php');

if (
  !isset($_POST['first_name']) ||
  !isset($_POST['last_name']) ||
  !isset($_POST['email']) ||
  !isset($_POST['email_confirm']) ||
  !isset($_POST['password']) ||
  !isset($_POST['password_confirm']) ||
  !isset($_POST['address_1']) ||
  !isset($_POST['city']) ||
  !isset($_POST['state']) ||
  !isset($_POST['zipcode'])
) {
  $msg = new Message(false, "Registration form missing items.");
  flash_redirect($msg, './register.php');
  exit;
}

$msg = register(
  $_POST['first_name'],
  $_POST['last_name'],
  $_POST['email'],
  $_POST['email_confirm'],
  $_POST['password'],
  $_POST['password_confirm'],
  $_POST['address_1'],
  $_POST['address_2'],
  $_POST['city'],
  $_POST['state'],
  $_POST['zipcode']
);

if ($msg->is_success) {
  flash_redirect($msg, './login.php');
  exit;
} else {
  flash_redirect($msg, './register.php');
  exit;
}
?>
