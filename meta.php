<?php
if ($_SERVER['REQUEST_URI'] === '/meta.php') {
  header('Location: error.php');
  exit();
}

function makeSummary($articles, $id, $maxCharacters)
{
  return substr(implode(' ', $articles[$id]['text']), 0, $maxCharacters);
}

(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ?
  $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] :
  $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$img = "img/deafult.jpg";

if (isset($_GET['read'])) {
  $articles = include 'articles.php';
  $id = isset($_GET['read']) ? htmlspecialchars($_GET['read']) : '';
  $title = $articles[$id]['heading'];
  $description = makeSummary($articles, $id, 150) . '...';
  $img = file_exists("img/" . $articles[$id]['image']) ? "img" . $articles[$id]['image'] : "img/deafult.jpg";
}
;

?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Primary Meta Tags -->
<title>
  <?php echo ($title); ?>
</title>
<meta name="title" content="<?php echo ($title); ?>">
<meta name="description" content="<?php echo ($description); ?>">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo ($url); ?>">
<meta property="og:title" content="<?php echo ($title); ?>">
<meta property="og:description" content="<?php echo ($description); ?>">
<meta property="og:image" content="<?php echo ($img); ?>">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?php echo ($url); ?>">
<meta property="twitter:title" content="<?php echo ($title); ?>">
<meta property="twitter:description" content="<?php echo ($description); ?>">
<meta property="twitter:image" content="<?php echo ($img); ?>">
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192" href="img/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
<link rel="manifest" href="img/favicon/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="img/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">