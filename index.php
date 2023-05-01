<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = 'News website';
  $description = 'Check out our cool news website!';

  include 'meta.php';
  include 'styles.html';
  ?>
</head>

<body id="index">
  <?php include 'header.php' ?>
  <main>
    <?php
    $articles = include 'articles.php';
    function dislayLastArticle($articles)
    {
      $post = end($articles);
      $image = file_exists('img/' . $post['image']) ? $post['image'] : 'default.jpg';
      $commentsNumber = count((array) $post["comments"]) == 0 ? 'No comments' : count((array) $post["comments"]);
      echo '<section class="featured-section">
      <div class="article article_featured" style="background-image:url(img/' . $image . ');">
        <div class="container container_wide">
          <div class="text-wrapper">
            <a href="post.php?read=' . $post["id"] . '">
              <h4 class="article__title">' . $post["heading"] . '</h4>
            </a>
            <ul class="article__info">
              <li class="article__info__item article__info__item_author">' . $post["author"]["login"] . '</li>
              <li class="article__info__item article__info__item_date">' . $post["date"] . '</li>
              <li class="article__info__item article__info__item_comments">' . $commentsNumber . '</li>
            </ul>
            <p class="article__description">' . makeSummary($articles, $post["id"], 200) . '</p>
            <a class="button button_light button_transparent" href="post.php?read=' . $post["id"] . '">Read more</a>
          </div>
        </div>
      </div>
    </section>';
    }
    dislayLastArticle($articles);
    ?>
    <section class="articles-section">
      <div class="container container_wide">
        <h3>More Articles</h3>
        <?php
        include 'display-articles.php';
        displayArticles($articles, 6, 1);
        ?>
        <a class="button" href="all-posts.php">More articles</a>
      </div>
    </section>
  </main>
  <?php include 'footer.php'; ?>
  <script defer src="js/script.js"></script>
</body>

</html>