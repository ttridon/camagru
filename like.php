<?php

  include('config/database.php');

  $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $db->exec("USE $DB_NAME;");

  $like_value = addslashes($_POST['like']);
  $name = addslashes($_POST['name']);

  $request = $db->exec("UPDATE images SET like_count=like_count + $like_value WHERE name='$name'");

  header('Location: ./gallery.php');

 ?>
