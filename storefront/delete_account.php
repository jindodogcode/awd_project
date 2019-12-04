<?php
// Ekene

require_once('utils.php');
require_once('db.php');
session_start();

$uid = $_SESSION['uid'];


$db = db_connect();
$query = '
  DELETE FROM Customers
  WHERE customer_id = ?
';
$stmt = $db->prepare($query);
$stmt->bind_param('i', $uid);
$stmt->execute();
if ($stmt->errno) {
  $error = $stmt->error;
  $db->rollback();
  $stmt->close();
  $db->close();
  $msg = new Message(false, 'Error deleting account. Please try again.');
  flash_redirect($msg, './');
  exit;
}
$stmt->close();
$db->close();

session_destroy();

$msg = new Message(true, 'Account deleted.');
flash_redirect($msg, './');
?>
