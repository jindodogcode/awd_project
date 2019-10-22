<?php

// a message with a boolean success status
class Message
{
  private $is_success;
  private $text;

  function __construct(bool $is_success, string $text)
  {
    $this->is_success = $is_success;
    $this->text = $text;
  }

  function __get($name)
  {
    return $this->$name;
  }
}

// Handles logging in
// returns a Message which can be passed to flash_redirect()
// to be displayed
function login(string $email, string $password)
{
  // trim and validation for email and password
  $email = strtolower(trim($email));
  $email_pattern = '/^\S+?@\w+?\.\w+$/';
  $is_good_email = preg_match($email_pattern, $email);
  $password = trim($password);
  $pword_pattern = '/^\S{8,32}$/';
  $is_good_pword = preg_match($pword_pattern, $password);

  // confirm valid input
  if (!$is_good_email || !$is_good_pword) {
    return new Message(false, 'Bad email or password.');
  }

  @$db = new mysqli('localhost', 'storefrontweb', 'storefrontweb', 'storefront');
  if (mysqli_connect_errno()) {
    return new Message(false, 'Error: could not connect to the database. Try again later.');
  }

  $query = '
    SELECT customer_id, password
    FROM Customers
    WHERE email = ?
  ';
  $stmt = $db->prepare($query);
  $stmt->bind_param('s', $email);
  $stmt->execute();
  $result = $stmt->get_result();

  // check for results
  if ($result->num_rows < 1) {
    $result->close();
    $stmt->close();
    $db->close();
    return new Message(false, 'Account not found.');
  }

  $user = $result->fetch_array();

  // veryify password
  if (!password_verify($email . $password, $user['password'])) {
    $result->close();
    $db->close();
    return new Message(false, 'Email and password did not match.');
  }

  $_SESSION['uid'] = $user['customer_id'];
  if (isset($_SESSION['scart'])) {
    $_SESSION['ucart'] = $_SESSION['scart'];
  } else {
    $_SESSION['ucart'] = [];
  }
  $result->close();
  $stmt->close();

  $query = '
    UPDATE Customers
    SET logged_in = NOW()
    WHERE customer_id = ?
  ';
  $stmt = $db->prepare($query);
  $stmt->bind_param('d', intval($_SESSION['uid']));
  $stmt->execute();
  $stmt->close();
  $db->close();
  return new Message(true, 'You have successfully logged in.');
}

// handles registration
// returns a Message which can be passed to flash_redirect()
// to be displayed
function register(
  string $first_name,
  string $last_name,
  string $email,
  string $email_confirm,
  string $password,
  string $password_confirm,
  string $address_1,
  $address_2,
  string $city,
  string $state,
  string $zipcode
) {
  // prepare input
  $first_name = trim($first_name);
  $last_name = trim($last_name);
  $email = strtolower(trim($email));
  $email_confirm = strtolower(trim($email_confirm));
  $password = trim($password);
  $password_confirm = trim($password_confirm);
  $address_1 = trim($address_1);
  if (!$address_2) {
    $address_2 = '';
  } else {
    $address_2 = trim($address_2);
  }
  $city = trim($city);
  $state = trim($state);
  $zipcode = trim($zipcode);

  // confirm correct input
  if ($email != $email_confirm) {
    return new Message(false, 'Email does not match.');
  }
  $email_pattern = '/^\S+?@\w+?\.\w+$/';
  $is_good_email = preg_match($email_pattern, $email);
  if (!$is_good_email) {
    return new Message(false, 'Invalid email address.');
  }
  if ($password != $password_confirm) {
    return new Message(false, 'Password does not match.');
  }
  $pword_pattern = '/^\S{8,32}$/';
  $is_good_pword = preg_match($pword_pattern, $password);
  if (!$is_good_pword) {
    return new Message(false, 'Invalid password.');
  }

  $password = password_hash($email.$password, PASSWORD_DEFAULT);

  // connect to db and start a transaction
  @$db = new mysqli('localhost', 'storefrontweb', 'storefrontweb', 'storefront');
  if (mysqli_connect_errno()) {
    return new Message(false, 'Error: could not connect to the database. Try again later.');
  }
  $db->begin_transaction();

  // insert customer
  $query = '
    INSERT INTO Customers (first_name, last_name, email, password)
    VALUES (?, ?, ?, ?)
  ';
  $stmt = $db->prepare($query);
  $stmt->bind_param('ssss', $first_name, $last_name, $email, $password);
  $stmt->execute();
  // rollback if error
  if ($stmt->errno) {
    $error = $stmt->error;
    $db->rollback();
    $stmt->close();
    $db->close();
    return new Message(false, 'Error: '.$error);
  }
  $stmt->close();
  $customer_id = $db->insert_id;

  // insert address
  $query = '
    INSERT INTO Addresses (line_one, line_two, city, state, zipcode)
    VALUES (?, ?, ?, ?, ?)
  ';
  $stmt = $db->prepare($query);
  $stmt->bind_param('sssss', $address_1, $address_2, $city, $state, $zipcode);
  $stmt->execute();
  // rollback if error
  if ($stmt->errno) {
    $error = $stmt->error;
    $db->rollback();
    $stmt->close();
    $db->close();
    return new Message(false, 'Error '.$error);
  }
  $stmt->close();
  $address_id = $db->insert_id;

  // connect customer to address
  $query = '
    INSERT INTO CustomerAddresses (customer_id, address_id, is_primary)
    VALUES (?, ?, TRUE)
  ';
  $stmt = $db->prepare($query);
  $stmt->bind_param('dd', $customer_id, $address_id);
  $stmt->execute();
  if ($stmt->errno) {
    $error = $stmt->error;
    $db->rollback();
    $stmt->close();
    $db->close();
    return new Message(false, 'Error '.$error);
  }
  $stmt->close();
  // commit transaction
  $db->commit();
  $db->close();

  return new Message(true, 'Account created.');
}

// redirects to the given url and displays the given message in the flash area
// depending on the is_success values of the Message, the flash will
// display with a different color
function flash_redirect(Message $msg, string $url)
{
  $is_success = $msg->is_success ? 'true' : 'false';
  echo '<form id="hidden-form" method="post" action="' 
    . htmlspecialchars($url) . '">';
  echo '<input type="hidden" name="is_success" value="'
    . htmlspecialchars($is_success) . '">';
  echo '<input type="hidden" name="msg" value="'
    . htmlspecialchars($msg->text) . '">';
  echo '</form>';
  echo '<script type="text/javascript" src="static/js/utils.js"></script>';
  echo '<script type="text/javascript"> utils.submitHiddenForm(); </script>';
}
?>
