<?php
if ($_SERVER['REQUEST_URI'] === '/new-comment.php') {
  header('Location: error.php');
  exit();
}
echo '
<h4>Leave a comment</h4>
<form class="comment-form" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="GET"
  autocomplete="off">
  <input type="hidden" name="read" value="' . $id . '" />
  <textarea name="comment" required></textarea>
  <button class="button" type="submit">Post comment</button>
</form>';

function addComment($articles, $id)
{
  include 'split-text.php';

  $comment = isset($_GET['comment']) ? ($_GET['comment']) : '';

  function checkCommentExists($comment)
  {
    if (isset($comment)) {
      return true;
    } else {
      return false;
    }
  }
  ;

  function uploadComment($articles, $id, $comment)
  {
    array_push(
      $articles[$id]['comments'],
      array(
        'name' => isset($_COOKIE['userName']) ? $_COOKIE['userName'] : 'Guest',
        'date' => time(),
        'text' => splitTextLines($comment),
        'edited' => false,
      )
    );
    ;
    file_put_contents('articles.php', '<?php return ' . var_export($articles, true) . ';');
  }
  ;

  if (checkCommentExists($comment)) {
    uploadComment($articles, $id, $comment);
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['comment'])) {
  addComment($articles, $id);
  echo '<script type="text/javascript">window.location.href="post.php?read=' . $id . '#comments";</script>';
}
?>