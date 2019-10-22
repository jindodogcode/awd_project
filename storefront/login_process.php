<?php
require('utils.php');
session_start();

if (!isset($_POST['email']) || !isset($_POST['password'])) {
  $msg = new Message(false, 'Email or password missing.');
  flash_redirect($msg, './login.php');
  exit;
}

$msg = login($_POST['email'], $_POST['password']);
if ($msg->is_success) {
  flash_redirect($msg, './index.php');
  exit;
} else {
  flash_redirect($msg, './login.php');
  exit;
}
?>
