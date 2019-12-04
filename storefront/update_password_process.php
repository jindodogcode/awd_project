<?php
// Bruk

require_once('utils.php');
require_once('db.php');
session_start();

$uid = $_SESSION['uid'];

if (!isset($_POST['password']) || !isset($_POST['password_confirm']) ||
!isset($_POST['old_password'])) {
  $msg = new Message(false, 'Something was missing, try again.');
  flash_redirect($msg, './');
  exit;
}

$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];
$old_password = $_POST['old_password'];

// connect to db
$login_strs = db_login_strs();
$db = new mysqli($login_strs[0], $login_strs[1], $login_strs[2], $login_strs[3]);
if (mysqli_connect_errno()) {
  $msg = new Message(false, 'Error: could not connect to the database. Try again later.');
  flash_redirect($msg, './');
  exit;
}

$query = '
  SELECT email, password
  FROM Customers
  WHERE customer_id = ?
';
$stmt = $db->prepare($query);
$stmt->bind_param('d', intval($uid));
$stmt->execute();
$result = $stmt->get_result();

// check for results
if ($result->num_rows < 1) {
  $result->close();
  $stmt->close();
  $db->close();
  $msg = new Message(false, 'Account not found. id='.$uid);
  flash_redirect($msg, './');
  exit;
}

$user = $result->fetch_array();

// veryify password
if (!password_verify($user['email'] . $old_password, $user['password'])) {
  $result->close();
  $stmt->close();
  $db->close();
  $msg = new Message(false, 'Wrong password.');
  flash_redirect($msg, './');
  exit;
}

$result->close();
$stmt->close();

$hash = password_hash($user['email'] . $password, PASSWORD_DEFAULT);

$query = '
  UPDATE Customers
  SET password = ?
  WHERE customer_id = ?
';

$stmt = $db->prepare($query);
$stmt->bind_param('sd', $hash, intval($uid));
$stmt->execute();


if ($stmt->errno) {
  $error = $stmt->error;
  $stmt->close();
  $db->close();
  $msg = new Message(false, 'Error ' . $error);
  flash_redirect($msg, './');
  exit;
}

$stmt->close();
$db->close();
$msg = new Message(true, 'Password updated.');

flash_redirect($msg, './account.php');
?>
