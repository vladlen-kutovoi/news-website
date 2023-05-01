<?php
if ($_SERVER['REQUEST_URI'] === '/comments.php') {
  header('Location: error.php');
  exit();
}

function showComments($articles, $id)
{
  $comments = loadArticle($articles, $id)['comments'];
  function countTimeSincePost($date)
  {
    $timeSincePost = time() - $date;

    if ($timeSincePost >= 0) {
      if ($timeSincePost < 60) {
        $unit = $timeSincePost == 1 ? 'second' : 'seconds';
        return "$timeSincePost $unit ago";
      } else if ($timeSincePost < (60 * 60)) {
        $unit = round($timeSincePost / 60) == 1 ? 'minute' : 'minutes';
        return round($timeSincePost / 60) . ' ' . $unit . ' ago';
      } else if ($timeSincePost < (60 * 60 * 24)) {
        $unit = round($timeSincePost / (60 * 60)) == 1 ? 'hour' : 'hours';
        return round($timeSincePost / (60 * 60)) . ' ' . $unit . ' ago';
      } else if ($timeSincePost < (60 * 60 * 24 * 7)) {
        $unit = round($timeSincePost / (60 * 60 * 24)) == 1 ? 'day' : 'days';
        return (round($timeSincePost / (60 * 60 * 24)) . ' ' . $unit . ' ago');
      } else if ($timeSincePost < (60 * 60 * 24 * 30)) {
        $unit = round($timeSincePost / (60 * 60 * 24 * 7)) == 1 ? 'week' : 'weeks';
        return (round($timeSincePost / (60 * 60 * 24 * 7)) . ' ' . $unit . ' ago');
      } else if ($timeSincePost < (60 * 60 * 24 * 365)) {
        $unit = round($timeSincePost / (60 * 60 * 24 * 30)) == 1 ? 'month' : 'months';
        return round($timeSincePost / (60 * 60 * 24 * 30)) . ' ' . $unit . ' ago';
      } else if ($timeSincePost >= (60 * 60 * 24 * 365)) {
        $unit = round($timeSincePost / (60 * 60 * 24 * 365)) == 1 ? 'year' : 'years';
        return (round($timeSincePost / (60 * 60 * 24 * 365)) . ' ' . $unit . ' ago');
      }
    }
  }
  ;
  function displayCommentButtons($comments, $id, $index)
  {
    $userName = isset($_COOKIE['userName']) ? $_COOKIE['userName'] : '';
    $userStatus = isset($_COOKIE['userStatus']) ? $_COOKIE['userStatus'] : '';
    if ($userStatus === 'admin' or ($userName === $comments[$index]['name'])) {
      return '
        <div class="button-wrapper">
          <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="GET" autocomplete="off">
            <input type="hidden" name="action" value="edit-comment" />
            <input type="hidden" name="read" value="' . $id . '" />
            <input type="hidden" name="index" value="' . $index . '" />
            <button class="button button_edit" type="submit">Edit</button>
          </form>
          <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="GET" autocomplete="off">
            <input type="hidden" name="action" value="delete-comment" />
            <input type="hidden" name="read" value="' . $id . '" />
            <input type="hidden" name="index" value="' . $index . '" />
            <button class="button button_delete" type="submit">Delete</button>
          </form>
        </div>';
    }
    ;
  }
  ;
  function displayComments($comments, $id)
  {
    for ($i = count($comments) - 1; $i >= 0; $i--) {
      $edited = ($comments[$i]['edited']) ? 'Edited' : '';
      echo '
        <li class="comments__item">
          <div class="comments__header">
            <span class="comments__name">' . $comments[$i]['name'] . '</span>
            <div class="comments__sideinfo">
              <span class="comments__date">' . countTimeSincePost($comments[$i]['date']) . '</span>
              <span class="comments__edited">' . $edited . '</span>
            </div>
          </div>';
      foreach ($comments[$i]['text'] as $key => $line) {
        echo '
            <p class="comments__text">' . $line . '</p>';
      }
      echo displayCommentButtons($comments, $id, $i);
      echo '</li>';
    }
    ;
  }
  ;

  displayComments($comments, $id);
}

function editComment($articles, $id)
{
  include 'split-text.php';
  $index = isset($_GET['index']) ? htmlspecialchars($_GET['index']) : '';
  $text = $articles[$id]['comments'][$index]['text'];

  function displayForm($id, $text, $index)
  {
    echo '
    <div class="comment-editor">
      <span>Edit comment</span>
      <form class="comment-form" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="GET" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update-comment" />  
        <input type="hidden" name="read" value="' . $id . '" />
        <input type="hidden" name="index" value="' . $index . '" />
        <textarea name="edited-comment" required>';
    foreach ($text as $key => $line) {
      echo $line;
    }
    echo '</textarea>
        <button class="button" type="submit">Update comment</button>
      </form>
    </div>';
  }
  ;

  function updateComment($articles, $id, $index)
  {
    $editedComment = isset($_GET['edited-comment']) ? ($_GET['edited-comment']) : '';

    $articles[$id]['comments'][$index]['text'] = splitTextLines($editedComment);
    $articles[$id]['comments'][$index]['edited'] = true;

    file_put_contents('articles.php', '<?php return ' . var_export($articles, true) . ';');

    echo '<script type="text/javascript">window.location.href="post.php?read=' . $id . '#comments";</script>';
  }
  ;

  if (isset($_GET['action']) and $_GET['action'] == 'edit-comment') {
    displayForm($id, $text, $index);
  }
  ;

  if (isset($_GET['action']) and $_GET['action'] == 'update-comment') {
    updateComment($articles, $id, $index);
  }
  ;
}
;

function deleteComment($articles, $id)
{
  $index = isset($_GET['index']) ? htmlspecialchars($_GET['index']) : '';

  if (!isset($id) or !isset($articles[$id]) or !$id or !$articles[$id] or $index == '') {
    echo '<p class="error">something went wrong. Try again later</p>';
    return false;
  }

  unset($artciles, $articles[$id]['comments'][$index]);
  $articles[$id]['comments'] = array_values($articles[$id]['comments']);
  file_put_contents('articles.php', '<?php return ' . var_export($articles, true) . ';');

  echo '<script type="text/javascript">window.location.href="post.php?read=' . $id . '#comments";</script>';
}
;

showComments($articles, $id);

if (isset($_GET['action']) and $_GET['action'] == 'delete-comment') {
  deleteComment($articles, $id);
}
;
if (isset($_GET['action']) and $_GET['action'] == 'edit-comment') {
  editComment($articles, $id);
}
;
if (isset($_GET['action']) and $_GET['action'] == 'update-comment') {
  editComment($articles, $id);
}
;
?>