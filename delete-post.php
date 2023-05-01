<?php
function deleteArticle()
{
  $articles = include 'articles.php';
  $id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';
  $fromPannel = isset($_POST['from-pannel']) ? true : false;

  if (!$id or !$articles[$id]) {
    header('Location: error.php');
    exit();
  } else {
    unset($artciles, $articles[$id]);
    file_put_contents('articles.php', '<?php return ' . var_export($articles, true) . ';');
    if ($fromPannel) {
      header('Location: admin-pannel.php?view=articles');
      exit();
    } else {
      header('Location: index.php');
      exit();
    }
  }
}
;
deleteArticle();
?>