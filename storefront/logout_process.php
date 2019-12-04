<?php
// Ekene

require_once('./utils.php');
session_start();

unset($_SESSION['uid']);
unset($_SESSION['cart']);

session_destroy();
flash_redirect(new Message(true, 'You have been logged out.'), './index.php');
?>
