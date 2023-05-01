<?php
if ($_SERVER['REQUEST_URI'] === '/footer.php') {
  header('Location: error.php');
  exit();
}
?>
<footer class="footer">
  <div class="container">
    <ul class="footer-menu">
      <li class="footer-menu__item">
        <a class="footer-menu__link" href="index.php">Home</a>
      </li>
      <li class="footer-menu__item">
        <a class="footer-menu__link" href="all-posts.php">Articles</a>
      </li>
      <?php
      if (isset($_COOKIE['userStatus']) and $_COOKIE['userStatus'] === 'admin') {
        echo '<li class="footer-menu__item">
                <a class="footer-menu__link" href="admin-pannel.php?view=articles">Admin pannel</a>
              </li>';
      }
      ;
      if (isset($_COOKIE['userStatus']) and ($_COOKIE['userStatus'] === 'admin' or $_COOKIE['userStatus'] === 'author')) {
        echo '<li class="footer-menu__item">
                <a class="footer-menu__link" href="new-post.php">Write an article</a>
              </li>';
      }
      ;
      if (!isset($_COOKIE['userName'])) {
        echo '<li class="footer-menu__item">
                <a class="footer-menu__link" href="register.php">Register</a>
              </li>
              <li class="footer-menu__item">
                <a class="footer-menu__link" href="login.php">Login</a>
              </li>';
      } else {
        echo '<li class="footer-menu__item">
                <a class="footer-menu__link" href="logout.php">Log out</a>
              </li>';
      }
      ?>
    </ul>
  </div>
</footer>