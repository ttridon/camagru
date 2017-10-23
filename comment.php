<?php

  include('./config/database.php');

  if (isset($_POST['name']) && isset($_POST['id']) && isset($_POST['comment'])) {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->exec("USE $DB_NAME;");

    $name = addslashes($_POST['name']);
    $image_id = addslashes($_POST['id']);
    $content = htmlentities(addslashes($_POST['comment']));

    $db->exec("INSERT INTO comments (name, image_id, slug, content) VALUES ('$name', '$image_id', '0', '$content')");
  }

  header('Location: ./gallery.php');

?>
