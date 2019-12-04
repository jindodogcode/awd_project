<?php
// Michael

session_start();
require_once('utils.php');
// Check for messages
if (isset($_POST['msg']) && isset($_POST['is_success'])) {
  if ($_POST['is_success'] == 'true') {
    $is_success = true;
  } else {
    $is_success = false;
  }
  $msg = new Message($is_success, $_POST['msg']);
}

// check if logged in
if (isset($_SESSION['uid'])) {
  $uid = $_SESSION['uid'];
}
// check for user and session cart
if (isset($_SESSION['cart'])) {
  // user cart
  $cart = $_SESSION['cart'];
} else {
  $cart = [];
}

define('HTML_FILTER', ENT_COMPAT | ENT_HTML5);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lambda Gear</title>
  <link rel="stylesheet" href="./static/css/style.css" />
  <link rel="icon" href="./static/images/favicon.png" />
</head>

<body>
  <header>
    <div class="header-brand-wrapper">
      <div class="header-logo-wrapper">
        <img src="./static/images/logo.png" alt="Lambda Logo" />
      </div>
      <div class="header-name-wrapper">
        <a href="./index.php">
          <h1><?php echo site_name(); ?></h1>
        </a>
      </div>
    </div>
    <div class="header-account-links-wrapper">
      <ul class="header-account-links">
        <?php
        $cart_size = 0;
        foreach ($cart as $k => $v) {
          $cart_size += $v;
        }
        if ($cart_size > 0) {
          echo '<li><a href="./cart.php">Cart(' .
            $cart_size .
            ')</a></li>';
        } else {
          echo '<li><a href="./cart.php">Cart</a></li>';
        }
        if (isset($uid)) {
          echo '<li><a href="./logout_process.php">Logout</a></li>';
          echo '<li><a href="./account.php">Account</a></li>';
        } else {
          echo '<li><a href="./login.php">Login</a></li>';
          echo '<li><a href="./register.php">Register</a></li>';
        }
        ?>
      </ul>
    </div>
  </header>

  <nav>
    <div class="nav-button-wrapper">
      <div class="dropdown">
        <button class="nav-button">Browse</button>
        <div class="dropdown-menu">
          <a href="./browse.php?q=laptop">Laptops</a>
          <a href="./browse.php?q=desktop">Desktops</a>
        </div>
      </div>
    </div>
    <div class="nav-search-wrapper">
      <form action="./search_results.php" method="get">
        <input class="search-input" type="search" name="q" placeholder="Search" />
        <input class="submit-input" type="submit" value="Search" />
      </form>
    </div>
  </nav>
  <?php
  if (isset($msg)) {
    $flash_status = $msg->is_success ? 'flash-good' : 'flash-bad';
    echo '<div class="flash ' .
      htmlspecialchars($flash_status, HTML_FILTER) .
      '">';
    echo '<p>' .
      htmlspecialchars($msg->text, HTML_FILTER) .
      '</p>';
  } else {
    echo '<div class="flash">';
  }
  echo '</div>';
  ?>

  <main>
