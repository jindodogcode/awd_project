<?php
// Bruk

require_once('utils.php');
session_start();

if (!isset($_GET['pid']) || !isset($_GET['name'])) {
  $msg = new Message(false, 'Ivalid item.');
  flash_redirect($msg, './');
  exit;
} else {
  $prod_id = $_GET['pid'];
  $name = $_GET['name'];
}

if (!isset($_GET['act'])) {
  $msg = new Message(false, 'Invalid action');
  flash_redirect($msg, './');
  exit;
} else {
  $act = $_GET['act'];
}

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}


switch ($act) {
  case 'add': {
      if (isset($_SESSION['cart'][$prod_id])) {
        $_SESSION['cart'][$prod_id]++;
      } else {
        $_SESSION['cart'][$prod_id] = 1;
      }
      $act_str = 'added to';
      break;
    }
  case 'sub': {
      if (isset($_SESSION['cart'][$prod_id])) {
        $_SESSION['cart'][$prod_id]--;
        if ($_SESSION['cart'][$prod_id] < 1) {
          unset($_SESSION['cart'][$prod_id]);
        }
      }
      $act_str ='subtracted from';
      break;
    }
  case 'rem': {
      unset($_SESSION['cart'][$prod_id]);
      $act_str = 'removed from';
      break;
    }
}



$msg = new Message(true, "$name $act_str your cart.");
flash_redirect($msg, './cart.php');
exit;
