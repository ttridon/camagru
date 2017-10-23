<?php
  include('database.php');

  try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(PDOException $e)
  {
    die('Erreur : ' . $e->getMessage());
  }

  try {
    $sql = "CREATE DATABASE IF NOT EXISTS $DB_NAME;
            USE $DB_NAME;";
    $db->exec($sql);
  }
  catch(PDOException $e)
  {
    die('Erreur : ' . $e->getMessage());
  }

  $db->query("CREATE TABLE IF NOT EXISTS users (
              id int(11) PRIMARY KEY AUTO_INCREMENT,
              username varchar(255) NOT NULL,
              password varchar(255) NOT NULL,
              email varchar(255) NOT NULL,
              activated varchar(255));");


  $db->query("CREATE TABLE IF NOT EXISTS images (
              id int(11) PRIMARY KEY AUTO_INCREMENT,
              name varchar(255) NOT NULL,
              user_id int(11) NOT NULL,
              pub_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              like_count int(11) NOT NULL);");

  $db->query("CREATE TABLE IF NOT EXISTS comments (
              id int(11) PRIMARY KEY AUTO_INCREMENT,
              name varchar(255) NOT NULL,
              image_id int(11) NOT NULL,
              slug varchar(255) NOT NULL,
              content longtext NOT NULL);");

  header("Location: ../gallery.php");
?>
