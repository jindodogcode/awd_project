<p style="text-align: center">Processing Order</p>
<?php
// Michael

require_once('utils.php');
require_once('db.php');
session_start();

$uid = $_SESSION['uid'];
$cart_total = $_SESSION['cart_total'];

$login_strs = db_login_strs();
$db = new mysqli($login_strs[0], $login_strs[1], $login_strs[2], $login_strs[3]);
if (mysqli_connect_errno()) {
  $msg = new Message(false, 'Error: could not connect to the database. Try again later.');
  flash_redirect($msg, './');
  exit;
}

$db->begin_transaction();

// if address is primary
if (
  $_SESSION['address']['first_name'] == $_POST['first_name'] &&
  $_SESSION['address']['last_name'] == $_POST['last_name'] &&
  $_SESSION['address']['line_one'] == $_POST['line_one'] &&
  $_SESSION['address']['line_two'] == $_POST['line_two'] &&
  $_SESSION['address']['city'] == $_POST['city'] &&
  $_SESSION['address']['state'] == $_POST['state'] &&
  $_SESSION['address']['zipcode'] == $_POST['zipcode']
) {
  $addr_id = $_SESSION['address']['address_id'];
  echo $addr_id;
  // else save new address
} else {
  $query = '
    INSERT INTO Addresses (line_one, line_two, city, state, zipcode)
    VALUES (?, ?, ?, ?, ?)
  ';
  $stmt = $db->prepare($query);
  $stmt->bind_param(
    'sssss',
    $_POST['line_one'],
    $_POST['line_two'],
    $_POST['city'],
    $_POST['state'],
    $_POST['zipcode']
  );

  $stmt->execute();
  // rollback if error
  if ($stmt->errno) {
    $error = $stmt->error;
    $db->rollback();
    $stmt->close();
    $db->close();
    $msg = new Message(false, 'Error processing order. Please try again.');
    flash_redirect($msg, './');
    exit;
  }
  $stmt->close();
  $addr_id = $db->insert_id;
}

// insert order details
$query = '
  INSERT INTO Orders (total_price, customer_id, shipping_address_id)
  VALUES (?, ?, ?)
';
$stmt = $db->prepare($query);
$stmt->bind_param('dii', $cart_total, $uid, $addr_id);
$stmt->execute();
if ($stmt->errno) {
  $error = $stmt->error;
  $db->rollback();
  $stmt->close();
  $db->close();
  $msg = new Message(false, ''. $error);
  flash_redirect($msg, './');
  exit;
}
$stmt->close();
$addr_id = $db->insert_id;

$stmt->close();
$order_id = $db->insert_id;

// insert order product details
$query = '
  INSERT INTO OrderProducts (order_id, product_id, quantity)
  VALUES (?, ?, ?)
';
foreach ($_SESSION['cart'] as $pid => $quant) {
  $stmt = $db->prepare($query);
  $stmt->bind_param('iii', $order_id, $pid, $quant);
  $stmt->execute();
  if ($stmt->errno) {
    $error = $stmt->error;
    $db->rollback();
    $stmt->close();
    $db->close();
    $msg = new Message(false, 'Error processing order. Please try again.');
    flash_redirect($msg, './');
    exit;
  }
  $stmt->close();
}

$db->commit();

$db->close();

// clean up session
$_SESSION['cart'] = [];
unset($_SESSION['address']);
unset($_SESSION['cart_total']);

$msg = new Message(true, 'Order Sucessfully Placed');
flash_redirect($msg, './');
exit;
?>
