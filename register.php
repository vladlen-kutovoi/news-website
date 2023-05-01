<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = "Register";
  $description = "Register on our website to read all the cool articles we write and post your own!";

  include 'meta.php';
  include 'styles.html';
  ?>
</head>

<body>
  <?php include 'header.php'; ?>

  <main class="non-index-main">
    <section class="login-section">
      <div class="post form">
        <h3>Register</h3>
        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
          autocomplete="off">
          <label>Login</label>
          <input type="text" name="login" required>
          <label>Password</label>
          <input type="password" name="password" required>
          <label>Confirm password</label>
          <input type="password" name="passwordRepeated" required>
          <label>Status</label>
          <select name="status">
            <option value="reader">Reader</option>
            <option value="author">Author</option>
            <option value="admin">Administrator</option>
          </select>
          <button class="button" type="submit">Register</button>
          <?php

          function registerUser()
          {
            $login = isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '';
            $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
            $passwordRepeated = isset($_POST['passwordRepeated']) ? htmlspecialchars($_POST['passwordRepeated']) : '';
            $status = isset($_POST['status']) ? htmlspecialchars($_POST['status']) : '';
            $db = include 'users.php';

            function checkValuesExist($login, $password, $passwordRepeated)
            {
              if ($login != "" and $password != "" and $passwordRepeated) {
                return true;
              } else {
                return false;
              }
            }
            ;
            function validateData($login, $password)
            {
              $verdict = true;
              if (!preg_match('/^[a-zA-Z0-9-_]+$/', $login)) {
                $verdict = false;
                echo '<p class="error">Username can only contain uppercase and lowercase letters, numbers, hyphens and underscores</p>';
              }
              if (strlen($password) < 5) {
                $verdict = false;
                echo '<p class="error">Password has to be at least 5 characters long</p>';
              }
              return $verdict;
            }
            function checkPasswordsSame($password, $passwordRepeated)
            {
              if ($password === $passwordRepeated) {
                return true;
              } else {
                echo '<p class="error">Passwords need to be the same</p>';
                return false;
              }
            }
            ;
            function checkUserNameAllowed($login)
            {
              $bannedNames = array('Guest');
              foreach ($bannedNames as $key => $bannedName) {
                if (strtolower($login) == strtolower($bannedName)) {
                  echo '<p class="error">This username is not allowed</p>';
                  return false;
                }
              }
              return true;
            }
            ;
            function checkUserNameUnique($login, $db)
            {
              foreach ($db as $key => $value) {
                if ($value['login'] === $login) {
                  echo '<p class="error">This username is already registerd</p>';
                  return false;
                }
              }
              return true;
            }
            ;
            function uploadUserData($db, $login, $password, $status)
            {
              array_push($db, array('login' => $login, 'password' => $password, 'status' => $status));
              file_put_contents('users.php', '<?php return ' . var_export($db, true) . ';');
            }
            ;

            function createCookie($login, $status)
            {
              $_SESSION['user'] = array('login' => $login, 'status' => $status);
              echo '<script type="text/javascript">window.location.href="cookie.php";</script>';
            }
            ;
            function generateErrors($db, $login, $password, $passwordRepeated)
            {
              $verdict = true;
              if (!checkValuesExist($login, $password, $passwordRepeated)) {
                $verdict = false;
              }
              if (!checkUserNameAllowed($login)) {
                $verdict = false;
              }
              if (!checkUserNameUnique($login, $db)) {
                $verdict = false;
              }
              if (!validateData($login, $password)) {
                $verdict = false;
              }
              if (!checkPasswordsSame($password, $passwordRepeated)) {
                $verdict = false;
              }
              return $verdict;
            }
            if (generateErrors($db, $login, $password, $passwordRepeated)) {
              uploadUserData($db, $login, $password, $status);
              createCookie($login, $status);
              echo 'Registered';
            }
            ;
          }
          ;

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            registerUser();
          }
          ;
          ?>
        </form>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>

  <script defer src="js/script.js"></script>
</body>

</html>