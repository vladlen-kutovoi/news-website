<?php
if ($_SERVER['REQUEST_URI'] === '/split-text.php') {
  header('Location: error.php');
  exit();
}
function splitTextLines($text)
{
  $splitText = preg_split("/\r\n|\n|\r/", $text);
  $pureText = array();
  foreach ($splitText as $key => $value) {
    array_push($pureText, htmlspecialchars($value));
  }
  return $pureText;
}
;
?>