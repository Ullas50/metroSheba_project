<?php
session_start();

// clear all session data
session_unset();
session_destroy();

//remove "remember me" cookie 
setcookie('remember_email', '', time() - 3600, '/');

header("Location: ../view/login.php");
exit;
