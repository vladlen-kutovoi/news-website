<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = "Log in";
  $description = "Log in to our website to read all the cool articles we write and post your own!";

  include 'meta.php';
  include 'styles.html';
  ?>
</head>

<body>
  <?php include 'header.php'; ?>

  <main class="non-index-main">
    <section class="login-section">
      <div class="post form">
        <h3>Log in</h3>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
          autocomplete="off">
          <label>Login</label>
          <input type="text" name="login" required>
          <label>Password</label>
          <input type="password" name="password" required>
          <button class="button" type="submit">Log in</button>
          <?php
          function loginUser()
          {
            $login = isset($_POST['login']) ? htmlspecialchars($_POST['login']) : '';
            $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
            $db = include 'users.php';

            function checkDataCorrect($db, $login, $password)
            {
              foreach ($db as $key => $value) {
                if (
                  $value['login'] === $login and
                  $value['password'] === $password
                ) {
                  return true;
                }
                ;
              }
              echo '<p class="error">Username or password is incorrect</p>';
              return false;
            }

            function createCookie($db, $login)
            {
              foreach ($db as $key => $value) {
                if ($value['login'] === $login) {
                  $status = $value['status'];
                }
              }
              ;
              $_SESSION['user'] = array('login' => $login, 'status' => $status);
              echo '<script type="text/javascript">window.location.href="cookie.php";</script>';
            }
            ;

            if (
              $login != "" and $password != "" and
              checkDataCorrect($db, $login, $password)
            ) {
              createCookie($db, $login);
            }
          }
          ;

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            loginUser();
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