<?php

include('config/database.php');

if (isset($_POST['delete'])) {
  $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $db->exec("USE $DB_NAME;");

  $PicToDel = addslashes($_POST['delete']);
  $db->exec("DELETE FROM images WHERE id='$PicToDel'");
}

header('Location: ./mounting.php');

?>
