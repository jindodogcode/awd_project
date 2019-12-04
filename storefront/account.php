<?php
// Ekene

require_once('header.php');
require_once('utils.php');

check_logged_in($uid);
?>

<section class="user-account-section">
  <h2>Account Settings</h2>
  <ul>
    <li><a href="./update_password.php">Change Password</a></li>
    <li><a href="./order_history.php">Order History</a></li>
    <li><a href="./delete_account.php">Delete Account</a></li>
  </ul>
</section>

<?php
require_once('footer.php');
?>
