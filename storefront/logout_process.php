<?php
require('./utils.php');
session_start();

unset($_SESSION['uid']);
unset($_SESSION['ucart']);
unset($_SESSION['scart']);

session_destroy();
flash_redirect(new Message(true, 'You have been logged out.'), './index.php');
?>
