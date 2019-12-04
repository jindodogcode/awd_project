<?php
// Bruk

function db_login_strs()
{
  return ['localhost', 'storefrontweb', 'storefrontweb', 'storefront'];
}

// creates and returns a connection the database
function db_connect()
{
  $login_strs = db_login_strs();
  $db = new mysqli($login_strs[0], $login_strs[1], $login_strs[2], $login_strs[3]);
  if (mysqli_connect_errno()) {
    echo '<div class="error-wrapper">';
    echo '<p>Error: Could not connect to database.<br />
    Please try again later.</p>';
    echo '</div>';
    require_once('footer.php');
    exit;
  }
  return $db;
}
?>
