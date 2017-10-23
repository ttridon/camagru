<?php

include('config/database.php');

session_start();

$target_dir = "./images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"]) && ($_POST["fileToUpload"] !== NULL)) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $alert = "error";
        $uploadOk = 1;
    } else {
        $alert = "notAnImage";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    $alert = "alreadyExists";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    $alert = "fileTooLarge";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $alert = "fileNotAllowed";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $alert = "errorUpload";
// if everything is ok, try to upload file
} else {

  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    $alert = "fileUploaded";
  } else {
    $alert = "errorUpload";
  }

  $name = $_FILES['fileToUpload']['name'];

  if ($_POST['filter']) {
    $source = imagecreatefrompng("./filter/".$_POST['filter'].".png"); // Le logo est la source
    $destination = imagecreatefrompng("./images/".$name); // La photo est la destination

    $largeur_destination = imagesx($destination);
    $hauteur_destination = imagesy($destination);

    imagecopy($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination);
    imagepng($destination, $name);
  }

  $new_name = './images/'.time().'.png';

  rename($name, $new_name);
  unlink("images/".$name);

  $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
  $db->exec("USE $DB_NAME;");

  $username = $_SESSION['username'];
  $query = $db->query("SELECT id FROM users WHERE username='$username'");
  $user_id = $query->fetch();
  $db->query("INSERT INTO images (name, user_id, like_count) VALUES ('$new_name', '$user_id[0]', '0')");
}

header('Location: ./mounting.php?'.$alert.'');

?>
