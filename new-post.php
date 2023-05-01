<?php
session_start();

$db = include 'users.php';
$userStatus = isset($_COOKIE['userStatus']) ? $_COOKIE['userStatus'] : '';
if (
  ($userStatus !== 'admin' and
    $userStatus !== 'author')
) {
  header('Location: error.php');
  exit();
}
;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = "Write and article";
  $description = "Write a new article, if you are the author or an administator";

  include 'meta.php';
  include 'styles.html';
  ?>
</head>

<body>
  <?php include 'header.php'; ?>

  <main class="non-index-main non-index-main_dark">
    <section class="new-post-section">
      <div class="post form">
        <h3>Write a new article</h3>
        <form class="new-post-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
          autocomplete="off" enctype="multipart/form-data">
          <label>Heading</label>
          <input type="text" name="heading" required>
          <label>Post Image</label>
          <input type="file" name="image" required>
          <label>Your article</label>
          <textarea name="text" required></textarea>
          <button class="button" type="submit">Post</button>
          <?php
          function addArticle()
          {
            $heading = isset($_POST['heading']) ? htmlspecialchars($_POST['heading']) : '';
            $text = isset($_POST['text']) ? $_POST['text'] : '';
            $articles = include 'articles.php';
            $image = $_FILES["image"];
            $imageFileType = strtolower(pathinfo(basename($image["name"]), PATHINFO_EXTENSION));
            $id = strtolower(str_replace(' ', '-', $heading));

            function checkArticleValuesExist($heading, $text, $image)
            {
              if ($heading != "" and $text != "" and $image != "") {
                return true;
              } else {
                return false;
              }
            }
            ;

            function checkIdUnique($articles, $id)
            {
              foreach ($articles as $key => $value) {
                if (strtolower($value['id']) == $id) {
                  echo '<p class="error">An article with this title is already posted. Please, come up with a new one.</p>';
                  return false;
                }
              }
              return true;
            }
            ;

            include 'check-article.php';

            function generateArticleErrors($articles, $id, $heading, $text, $image, $imageFileType)
            {
              $verdict = true;
              if (!checkArticleValuesExist($heading, $text, $image)) {
                $verdict = false;
              }
              if (!checkIdUnique($articles, $id)) {
                $verdict = false;
              }
              if (!checkHeadingLength($heading)) {
                $verdict = false;
              }
              if (!checkImageSize($image)) {
                $verdict = false;
              }
              if (!checkImageType($imageFileType)) {
                $verdict = false;
              }
              return $verdict;
            }
            ;

            include 'upload-image.php';
            include 'split-text.php';

            function uploadArticle($articles, $id, $heading, $text, $image, $imageFileType)
            {
              $articles[$id] =
                array(
                  'id' => $id,
                  'heading' => $heading,
                  'image' => uploadImage($image, generateImageName($imageFileType)),
                  'date' => date("M jS, Y"),
                  'text' => splitTextLines($text),
                  'author' =>
                  array(
                    'login' => $_COOKIE['userName'],
                    'status' => $_COOKIE['userStatus'],
                  ),
                  'comments' => array(),
                );
              file_put_contents('articles.php', '<?php return ' . var_export($articles, true) . ';');
            }
            ;

            if (generateArticleErrors($articles, $id, $heading, $text, $image, $imageFileType)) {
              uploadArticle($articles, $id, $heading, $text, $image, $imageFileType);
              echo '<script type="text/javascript">window.location.href="post.php?read=' . $id . '";</script>';
            }
          }
          ;

          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            addArticle();
          }

          ?>
        </form>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>

  <script defer src="js/script.js"></script>
</body>

</html>