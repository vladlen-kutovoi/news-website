<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = "Edit an article";
  $description = "Edit an article, if you are the author or an administator";

  include 'meta.php';
  include 'styles.html';
  ?>
</head>

<body>
  <?php include 'header.php'; ?>

  <main class="non-index-main non-index-main_dark">
    <section class="new-post-section">
      <div class="post form">
        <h3>Edit an article</h3>

        <?php
        function editArticle()
        {
          $articles = include 'articles.php';
          $id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';

          if (!$id or !$articles[$id] or ($_COOKIE['userStatus'] != 'admin' and $_COOKIE['userName'] !== $articles[$id]['author']['login'])) {
            echo '<script type="text/javascript">window.location.href="error.php";</script>';
          }

          $heading = $articles[$id]['heading'];
          $text = implode("\r\n", $articles[$id]['text']);

          function displayForm($id, $heading, $text)
          {
            echo '
            <form class="new-post-form"  action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="POST" autocomplete="off" enctype="multipart/form-data">
              <input type="hidden" name="action" value="update" />  
              <input type="hidden" name="id" value="' . $id . '" />  
              <label>Heading</label>
              <input type="text" name="heading" value="' . $heading . '" required>
              <label>Post Image</label>
              <input type="file" name="image">
              <label>Your article</label>
              <textarea name="text" required>' . $text . '</textarea>
              <button class="button" type="submit">Update</button>
            </form>';
          }
          ;

          function uploadEdits($articles, $id)
          {
            $heading = isset($_POST['heading']) ? htmlspecialchars($_POST['heading']) : '';
            $text = isset($_POST['text']) ? ($_POST['text']) : '';
            $image = $_FILES["image"];
            $imageFileType = strtolower(pathinfo(basename($image["name"]), PATHINFO_EXTENSION));

            function checkEditedValuesExist($heading, $text)
            {
              if ($heading != "" and $text != "") {
                return true;
              } else {
                return false;
              }
            }
            ;

            include 'check-article.php';

            function generateEditedErrors($heading, $text, $image, $imageFileType)
            {
              $verdict = true;
              if (!checkEditedValuesExist($heading, $text)) {
                $verdict = false;
              }
              if (!checkHeadingLength($heading)) {
                $verdict = false;
              }
              if ($image['type'] != '') {
                if (!checkImageSize($image)) {
                  $verdict = false;
                }
                if (!checkImageType($imageFileType)) {
                  $verdict = false;
                }
              }
              return $verdict;
            }
            ;

            include 'upload-image.php';
            include 'split-text.php';

            function updateArticle($articles, $id, $heading, $text, $image, $imageFileType)
            {
              $articles[$id]['heading'] = $heading;
              $articles[$id]['text'] = splitTextLines($text);
              if ($image['type'] != '') {
                echo 'true <br>';
                $articles[$id]['image'] = uploadImage($image, generateImageName($imageFileType));
              }

              file_put_contents('articles.php', '<?php return ' . var_export($articles, true) . ';');
            }
            ;
            if (generateEditedErrors($heading, $text, $image, $imageFileType)) {
              updateArticle($articles, $id, $heading, $text, $image, $imageFileType);
              echo '<script type="text/javascript">window.location.href="post.php?read=' . $id . '";</script>';
            }
            ;
          }
          ;

          displayForm($id, $heading, $text);
          ;

          if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] === 'update') {
            uploadEdits($articles, $id);
          }
          ;
        }
        ;
        editArticle();
        ?>

      </div>
    </section>
  </main>
  <?php include 'footer.php'; ?>

  <script defer src="js/script.js"></script>
</body>

</html>