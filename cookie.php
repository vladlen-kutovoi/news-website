<?php
session_start();
setcookie('userName', $_SESSION['user']['login'], time() + (60 * 60 * 24 * 30), '/');
setcookie('userStatus', $_SESSION['user']['status'], time() + (60 * 60 * 24 * 30), '/');
header('Location: index.php');
exit();
?>