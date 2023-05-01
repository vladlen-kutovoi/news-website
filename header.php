<?php
if ($_SERVER['REQUEST_URI'] === '/header.php') {
  header('Location: error.php');
  exit();
}
?>
<header class="header">
  <h1 class="visually-hidden">
    <?php echo ($title); ?>
  </h1>
  <div class="container">
    <a class="logo-link" href="index.php">
      <i class="far fa-newspaper"></i>
    </a>
    <nav class="header__nav">
      <h2 class="visually-hidden">Main navigation</h2>
      <button class="menu-button">
        <span class="visually-hidden">Menu button</span>
        <span class="menu-button__item"></span>
      </button>
      <div class="menu-wrapper">
        <ul class="main-menu">
          <li class="main-menu__item">
            <a class="main-menu__link" href="index.php">Home</a>
          </li>
          <li class="main-menu__item">
            <a class="main-menu__link" href="all-posts.php">Articles</a>
          </li>
          <?php
          if (isset($_COOKIE['userStatus']) and $_COOKIE['userStatus'] === 'admin') {
            echo '<li class="main-menu__item">
                    <a class="main-menu__link" href="admin-pannel.php?view=articles">Admin pannel</a>
                  </li>';
          }
          ;
          if (isset($_COOKIE['userStatus']) and ($_COOKIE['userStatus'] === 'admin' or $_COOKIE['userStatus'] === 'author')) {
            echo '<li class="main-menu__item">
                    <a class="main-menu__link" href="new-post.php">Write an article</a>
                  </li>';
          }
          ;
          if (!isset($_COOKIE['userName'])) {
            echo '<li class="main-menu__item">
                    <a class="main-menu__link" href="register.php">Register</a>
                  </li>
                  <li class="main-menu__item">
                    <a class="main-menu__link" href="login.php">Login</a>
                  </li>';
          } else {
            echo '<li class="main-menu__item">
                    <a class="main-menu__link" href="logout.php">Log out</a>
                  </li>';
          }
          ?>
        </ul>
      </div>
    </nav>
  </div>
</header>