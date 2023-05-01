<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = "News article";
  $description = "Read more instersting articles on our wonderful website!";

  include 'meta.php';
  include 'styles.html';
  ?>
</head>

<body>
  <?php include 'header.php'; ?>
  <main class="non-index-main">
    <article class="post-section">
      <div class="post">

        <?php
        $articles = include 'articles.php';
        $id = isset($_GET['read']) ? htmlspecialchars($_GET['read']) : '';
        function loadArticle($articles, $id)
        {
          foreach ($articles as $key => $value) {
            if ($value['id'] === $id) {
              return $value;
            }
          }
          return false;
        }
        function displayArticle($articles, $id)
        {
          $post = loadArticle($articles, $id);
          if ($post) {
            //Image
            $image = file_exists("img/" . $post['image']) ? $post['image'] : "default.jpg";
            echo '<img class="post__img" src="img/' . $image . '" alt="' . $post['heading'] . '">';
            //Heading
            echo '<h1 class="post__title">' . $post["heading"] . '</h1>';
            // Article Info
            echo '
            <ul class="article__info">
              <li class="article__info__item article__info__item_author">' . $post["author"]["login"] . '</li>
              <li class="article__info__item article__info__item_date">' . $post["date"] . '</li>
            </ul>';
            // Text
            foreach ($post['text'] as $key => $paragraph) {
              echo '
              <p class="post__paragraph">' . $paragraph . '</p>';
            }
          } else {
            echo '<script type="text/javascript">window.location.href="404.php";</script>';
          }
        }

        function displayButtons($articles, $id)
        {
          $userName = isset($_COOKIE['userName']) ? $_COOKIE['userName'] : '';
          $userStatus = isset($_COOKIE['userStatus']) ? $_COOKIE['userStatus'] : '';
          if (
            $userStatus === 'admin' or
            ($userName === $articles[$id]['author']['login'] and $userStatus === 'author')
          ) {
            echo '
            <div class="button-wrapper">
                <form action="edit-post.php" method="POST" autocomplete="off">
                  <input type="hidden" name="action" value="edit" />
                  <input type="hidden" name="id" value="' . $id . '" />
                  <button class="button button_edit" type="submit">Edit</button>
                </form>
                <form action="delete-post.php" method="POST" autocomplete="off">
                  <input type="hidden" name="action" value="delete" />
                  <input type="hidden" name="id" value="' . $id . '" />
                  <button class="button button_delete" type="submit">Delete</button>
                </form>
              </div>';
          }
        }
        ;

        displayArticle($articles, $id);
        displayButtons($articles, $id);
        ?>

      </div>
    </article>
    <section class="read-more-section">
      <div class="post">
        <h3>Read more</h3>
        <ul class="read-more">
          <?php
          function displayReadMore($articles, $id, $postNumber)
          {
            $i = 0;
            foreach (array_reverse($articles) as $key => $post) {
              if ($id != $post['id']) {
                $image = file_exists("img/" . $post['image']) ? $post['image'] : "default.jpg";
                echo '
                  <li class="read-more__item">
                    <a class="img-wrapper" href="post.php?read=' . $post['id'] . '">
                      <img src="img/' . $image . '" alt="' . $post['heading'] . '">
                    </a>
                    <a href="post.php?read=' . $post['id'] . '">
                      <h4>' . $post['heading'] . '</h4>
                    </a>
                  </li>';
                $i++;
                if ($i >= $postNumber) {
                  break;
                }
              }
            }
          }
          displayReadMore($articles, $id, 2);
          ;
          ?>

        </ul>
      </div>
    </section>
    <section class="comment-section" id="comments">
      <div class="post">
        <h3>Discussion</h3>
        <?php include 'new-comment.php'; ?>
        <ul class="comments">
          <?php include 'comments.php'; ?>
        </ul>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>

  <script defer src="js/script.js"></script>
</body>

</html>