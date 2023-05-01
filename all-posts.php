<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = 'All articles';
  $description = 'Read all articles that have been posted on our website';

  include 'meta.php';
  include 'styles.html';
  ?>
</head>

<body>
  <?php include 'header.php' ?>
  <main>
    <section class="articles-section">
      <div class="container container_wide">
        <h3>All Articles</h3>
        <?php
        $articles = include 'articles.php';
        include 'display-articles.php';
        displayArticles($articles, '*', 0);
        ?>
      </div>
    </section>
  </main>
  <?php include 'footer.php'; ?>
  <script defer src="js/script.js"></script>
</body>

</html>