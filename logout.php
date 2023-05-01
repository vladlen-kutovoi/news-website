<?php
if (isset($_COOKIE['userName'])) {
  unset($_COOKIE['userName']);
  setcookie('userName', null, -1, '/');
}
if (isset($_COOKIE['userStatus'])) {
  unset($_COOKIE['userStatus']);
  setcookie('userStatus', null, -1, '/');
}
header('Location: index.php');
exit();
?>