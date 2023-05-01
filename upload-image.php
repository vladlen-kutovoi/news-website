<?php
if ($_SERVER['REQUEST_URI'] === '/upload-image.php') {
  header('Location: error.php');
  exit();
}
function generateImageName($imageFileType)
{
  $newName = sprintf("%09d", mt_rand(1, 999999999));
  $imagesList = scandir(__DIR__ . '/img');
  do {
    $unique = true;
    foreach ($imagesList as $key => $value) {
      if ($value === $newName . '.' . $imageFileType) {
        $unique = false;
        $newName .= '1';
      }
    }
  } while ($unique === false);

  return $newName . '.' . $imageFileType;
}
;

function uploadImage($image, $imageName)
{
  $imagePath = __DIR__ . '/img/' . $imageName;
  move_uploaded_file($image["tmp_name"], $imagePath);
  return $imageName;
}
;
?>