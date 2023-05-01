<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = '404 Page not found';
  $description = 'Looks like we do not have such page on our website';

  include 'meta.php';
  include 'styles.html';
  ?>
</head>

<body id="index">
  <?php include 'header.php' ?>
  <main>
    <section class="error-section">
      <div class="container">
        <div class="error-block">
          <span class="error-block__warning">404</span>
          <span class="error-block__message">Looks like you are lost</span>
          <a class="button button_light button_transparent" href="index.php">Go back home</a>
        </div>
      </div>
    </section>
  </main>
  <script defer src="js/script.js"></script>
</body>

</html>