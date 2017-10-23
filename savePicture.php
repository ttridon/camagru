<?php
  include('config/database.php');

  session_start();

  if ($_POST['data']) {
    $data = addslashes($_POST['data']);

    list($type, $data) = explode(';', $data);
    list(, $data) = explode(',', $data);
    $data = base64_decode($data);
    $name = './images/'.time().'.png';
    file_put_contents($name, $data);

    if ($_POST['filter']) {
      $source = imagecreatefrompng("./filter/".$_POST['filter'].".png"); // Le logo est la source
      $destination = imagecreatefrompng($name); // La photo est la destination

      $largeur_destination = imagesx($destination);
      $hauteur_destination = imagesy($destination);

      imagecopy($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination);
      imagepng($destination, $name);
    }

    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->exec("USE $DB_NAME;");

    $username = $_SESSION['username'];
    $query = $db->query("SELECT id FROM users WHERE username='$username'");
    $user_id = $query->fetch();
    $db->query("INSERT INTO images (name, user_id, like_count) VALUES ('$name', '$user_id[0]', '0')");

  }
  header('Location: ./mounting.php');
?>
