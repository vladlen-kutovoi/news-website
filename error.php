<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = 'No access to this page';
  $description = 'Looks like you have no access to this page';

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
          <span class="error-block__warning">Error!</span>
          <span class="error-block__message">An error occured. Probably you are not allowed access this page.</span>
          <a class="button button_light button_transparent" href="index.php">Go back home</a>
        </div>
      </div>
    </section>
  </main>
  <script defer src="js/script.js"></script>
</body>

</html>