<?php
function displayArticles($articles, $numberToDisplay, $numberToSkip)
{
  echo '<ul class="articles">';
  $i = 0;
  foreach (array_reverse($articles) as $key => $post) {
    $i++;
    if ($i <= $numberToSkip) {
      continue;
    }
    $image = file_exists('img/' . $post['image']) ? $post['image'] : 'default.jpg';
    echo '<li class="article">
    <div class="img-wrapper">
      <a href="post.php?read=' . $post["id"] . '">
        <img src="img/' . $image . '" alt="' . $post["heading"] . '">
      </a>
    </div>
    <div class="text-wrapper">
      <a href="post.php?read=' . $post["id"] . '">
        <h4 class="article__title">' . $post["heading"] . '</h4>
      </a>
      <p class="article__description">' . makeSummary($articles, $post["id"], 130) . '</p>
      <ul class="article__info">
        <li class="article__info__item article__info__item_author">' . $post["author"]["login"] . '</li>
        <li class="article__info__item article__info__item_date">' . $post["date"] . '</li>
      </ul>
    </div>
  </li>';
    if ($numberToDisplay !== '*' and ($i - $numberToSkip) >= $numberToDisplay) {
      break;
    }
  }
  echo '</ul>';
}
?>