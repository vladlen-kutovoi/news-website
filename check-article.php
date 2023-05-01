<?php
if ($_SERVER['REQUEST_URI'] === '/check-article.php') {
  header('Location: error.php');
  exit();
}
function checkHeadingLength($heading)
{
  if (strlen($heading) > 60) {
    echo '<p class="error">Your heading should not be longer than 60 characters including spaces.</p>';
    return false;
  } else {
    return true;
  }
}
;

function checkImageSize($image)
{
  if ($image["size"] > 1700000) {
    echo '<p class="error">Sorry, your file is too large. Choose an image that is less than 1,7 MB.</p>';
    return false;
  } else {
    return true;
  }
}
;

function checkImageType($imageFileType)
{
  if (
    $imageFileType != "jpg" &&
    $imageFileType != "png" &&
    $imageFileType != "jpeg" &&
    $imageFileType != "webp"
  ) {
    echo '<p class="error">Sorry, only JPG, JPEG, PNG & WEBP files are allowed.</p>';
    return false;
  } else {
    return true;
  }
}
;
?>