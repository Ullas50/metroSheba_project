<?php
session_start();

/* REMOVE ALL SESSION DATA */
session_unset();
session_destroy();

/* REMOVE REMEMBER ME COOKIE (IF EXISTS) */
setcookie('remember_email', '', time() - 3600, '/');

/* REDIRECT TO LOGIN PAGE */
header("Location: ../view/login.php");
exit;
