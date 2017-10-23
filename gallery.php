<?php
include('header.php');

$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$db->exec("USE $DB_NAME;");

$request = $db->query("SELECT COUNT(id) FROM images");
$nbrImage = $request->fetch();
$perPage = 12;
$nbPage = ceil($nbrImage[0] / $perPage);

if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbPage) {
  $cPage = $_GET['page'];
} else {
  $cPage = 1;
}

$request = $db->query("SELECT * FROM images LIMIT ".(($cPage - 1) * $perPage).", ".$perPage."");
$images = $request->fetchAll();

$request = $db->query("SELECT * FROM comments");

echo '<table>';
echo    '<tr>';

foreach ($images as $key => $value) {
  // echo ($key % 5);
    $request = $db->query("SELECT * FROM comments WHERE image_id='".$value[0]."'");
    $comments = $request->fetchAll();

    echo '  <td>
              <img class="photos" src="'.$value[1].'" alt="photo">
              <div>';

              foreach ($comments as $key_b => $value_b) {
                if ($value_b[2] === $value[0]) {
                  echo $value_b[1].": <br />";
                  echo $value_b[4]."<br />";
                }
              }

    if (isset($_SESSION['username'])) {
      echo     '</div>
      <form action="./comment.php" method="POST">
      <input type="text" name="comment" value="">
      <input type="submit" name="envoyer" value="OK">
      <input type="hidden" name="name" value="'.$_SESSION['username'].'">
      <input type="hidden" name="id" value="'.$value[0].'">
      </form>
      <form action="./like.php" method="POST">
      <input type="submit" name="like" value="1">
      <input type="submit" name="like" value="-1">
      <input type="hidden" name="name" value="'.$value[1].'">
      Nb Likes: '.$value[4].'
      </form>';
    }
    echo      '</td>';
    $value = $key + 1;
    if (($value % 6) == 0) {
      echo '</tr>
            <tr>';
    }
}

echo '</tr>';
echo '</table>';

for ($i = 1; $i <= $nbPage; $i++) {
  echo "<a href=\"gallery.php?page=".$i."\">".$i." / </a>";
}

include('footer.php');

?>
