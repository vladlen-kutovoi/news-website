<?php
session_start();
$users = include 'users.php';
$articles = include 'articles.php';

function checkIfAdmin()
{
  $userStatus = isset($_COOKIE['userStatus']) ? $_COOKIE['userStatus'] : '';
  if ($userStatus != 'admin') {
    header('Location: error.php');
    exit();
  }
}
;
checkIfAdmin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $title = "Admin pannel";
  $description = "Manage articles and users, if you are an administator";

  include 'meta.php';
  include 'styles.html';
  ?>
</head>

<body>
  <?php include 'header.php'; ?>

  <main class="non-index-main non-index-main_dark">
    <section class="pannel-section">
      <div class="post">
        <h3>Admin pannel</h3>
        <div class="pannel">
          <?php
          function showArticleList($articles)
          {
            echo '
              <ul class="pannel__buttons">
                <li class="pannel__buttons__item">
                  <span>Articles</span>
                </li>
                <li class="pannel__buttons__item pannel__buttons__item_inactive">
                  <a href="admin-pannel.php?view=users"><span>Users</span></a>
                </li>
              </ul>
              <ul class="pannel__infotable pannel__infotable_articles">';

            foreach (array_reverse($articles) as $key => $value) {
              $id = $value['id'];
              echo '
                <li class="pannel__infotable__item">
                  <a href="post.php?read=' . $id . '">' . $value["heading"] . '</a>
                  <div class="button-wrapper">
                    <form class="pannel__form" action="edit-post.php" method="POST" autocomplete="off">
                      <input type="hidden" name="action" value="edit" />
                      <input type="hidden" name="id" value="' . $id . '" />
                      <button class="button button_edit" type="submit">Edit</button>
                    </form>
                    <form class="pannel__form" action="delete-post.php" method="POST" autocomplete="off">
                      <input type="hidden" name="action" value="delete" />
                      <input type="hidden" name="id" value="' . $id . '" />
                      <input type="hidden" name="from-pannel" value="true" />
                      <button class="button button_delete" type="submit">Delete</button>
                    </form>
                  </div>
                </li>';
            }

            echo '</ul>';
          }
          ;

          function showUsersList($users)
          {
            $userName = isset($_COOKIE['userName']) ? $_COOKIE['userName'] : '';

            echo '
              <ul class="pannel__buttons">
                <li class="pannel__buttons__item pannel__buttons__item_inactive">
                  <a href="admin-pannel.php?view=articles"><span>Articles</span></a>
                </li>
                <li class="pannel__buttons__item">
                  <span>Users</span>
                </li>
              </ul>
              <ul class="pannel__infotable pannel__infotable_users">';

            foreach ($users as $key => $value) {
              if ($value['login'] !== $userName) {
                echo '
                  <li class="pannel__infotable__item">
                    <span>' . $value['login'] . '</span>
                    <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="GET">
                    <input type="hidden" name="view" value="users" />
                    <input type="hidden" name="action" value="change-status" />
                    <input type="hidden" name="index" value="' . $key . '" />
                    <select name="status">
                      <option value="admin" ' . (($value['status'] === 'admin') ? 'selected="selected"' : "") . '>Administartor</option>
                      <option value="author" ' . (($value['status'] === 'author') ? 'selected="selected"' : "") . '>Author</option>
                      <option value="reader" ' . (($value['status'] === 'reader') ? 'selected="selected"' : "") . '>Reader</option>
                    </select>
                    <button class="button" type="submit">Update</button>
                    </form>
                    <form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="GET">
                    <input type="hidden" name="view" value="users" />
                    <input type="hidden" name="action" value="delete-user" />
                    <input type="hidden" name="index" value="' . $key . '" />
                    <button class="button" type="submit">Delete</button>
                    </form>
                  </li>';
              }
              ;
            }
            echo '</ul>';
            ;
          }
          ;

          function changeUserStatus($users)
          {
            $index = isset($_GET['index']) ? htmlspecialchars($_GET['index']) : '';
            $status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';

            if (isset($_GET['index']) and isset($_GET['status']) and $index != '' and $status != '') {
              $users[$index]['status'] = $status;
              file_put_contents('users.php', '<?php return ' . var_export($users, true) . ';');
            }
          }
          ;
          function deleteUser($users)
          {
            $index = isset($_GET['index']) ? htmlspecialchars($_GET['index']) : '';
            if (isset($_GET['index'])) {
              array_splice($users, $index, 1);
              file_put_contents('users.php', '<?php return ' . var_export($users, true) . ';');
            }
          }
          ;

          if (isset($_GET['view']) and $_GET['view'] == 'articles') {
            showArticleList($articles);
          } else if (isset($_GET['view']) and $_GET['view'] == 'users') {
            showUsersList($users);
          } else {
            showArticleList($articles);
          }

          if (isset($_GET['action']) and $_GET['action'] == 'change-status') {
            changeUserStatus($users);
            echo '<script type="text/javascript">window.location.href="admin-pannel.php?view=users";</script>';
          }
          if (isset($_GET['action']) and $_GET['action'] == 'delete-user') {
            deleteUser($users);
            echo '<script type="text/javascript">window.location.href="admin-pannel.php?view=users";</script>';
          }
          ;
          ?>
        </div>
      </div>
    </section>
  </main>

  <?php include 'footer.php'; ?>

  <script defer src="js/script.js"></script>
</body>

</html>