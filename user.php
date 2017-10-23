<?php

  include('./config/database.php');

  session_start();

  //log out
  if (isset($_GET['action']) && $_GET['action'] === "logout") {
    unset($_SESSION['username']);

    header("Location: ./gallery.php?alert=logout");
    exit();
  }

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  function testPassword($password) {
    if (strlen($password) < 8 || !preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password)) {
      return 0;
    }
    return 1;
  }

  //missing password
  if (isset($_POST['action']) && $_POST['action'] === "Send the request" && isset($_POST['mail'])) {
    $mail = addslashes($_POST['mail']);

    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->exec("USE $DB_NAME;");

    $request = $db->query("SELECT * FROM users WHERE email='$mail'");

    if ($request->rowCount() > 0) {
      $char = "aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789";

      $new_pwd = substr(str_shuffle($char), 0 , 8);
      while (!testPassword($new_pwd)) {
        $new_pwd = substr(str_shuffle($char), 0 ,8);
      }

      $message = 'Voici votre nouveau mot de pass: '.$new_pwd.'

                  ---------------
                  Ceci est un mail automatique, Merci de ne pas y répondre.';


      mail($mail, "Email by Camagru", $message, "Voici...");

      $new_password = sha1($new_pwd);
      $db->exec("UPDATE users SET password='$new_password' WHERE email='$mail'");

      header("Location: ./gallery.php?alert=newPassword");
      exit();
    }
    header("Location: ./gallery.php?alert=noUserFound");
    exit();
  }

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  //activated account
  if (isset($_GET['action']) && $_GET['action'] === "mailVerification" && isset($_GET['username'])) {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->exec("USE $DB_NAME;");

    $username = addslashes($_GET['username']);

    $db->exec("UPDATE users SET activated='true' WHERE username='$username'");

    header("Location: ./gallery.php?alert=accountActivated");
    exit();
  }

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  //sign up
  if ($_POST['ok'] && $_POST['ok'] === "Sign in") {
    if (!$_POST['username'] || !$_POST['password']) {
      header("Location: ./gallery.php?alert=missingIdentifiants");
      exit();
    }
    else {
      $username = addslashes($_POST['username']);
      $password = sha1($_POST['password']);

      $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $db->exec("USE $DB_NAME;");

      $request = $db->query("SELECT * FROM users WHERE username='$username' AND password='$password'");
      $user = $request->fetch();
      if ($request->rowCount() > 0 && $user[4] === "true") {
        $_SESSION['username'] = $username;
      }
      else {
        header("Location: ./gallery.php?alert=wrongIdentifiants");
        exit();
      }
    }
    header("Location: ./gallery.php?alert=connected");
    exit();
  }

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

  //register

  if ($_POST['ok'] && $_POST['ok'] === "Create your account") {
    if (!$_POST['username'] || !$_POST['password'] || !$_POST['re-password'] || !$_POST['email']) {
      header("Location: ./gallery.php?alert=invalidArguments");
      exit();
    }
    else {
      $username = addslashes($_POST['username']);
      $password = sha1($_POST['password']);
      $re_password = sha1($_POST['re-password']);
      $email = addslashes($_POST['email']);

      if ($password != $re_password) {
          header("location: ./gallery.php?alert=differentPassword");
          exit();
      }

      if (!testPassword(addslashes($_POST['password']))) {
        header("Location: ./gallery.php?alert=passwordNotSecured");
        exit();
      }

      //create user
      $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $db->exec("USE $DB_NAME;");
      $select = $db->query("SELECT id FROM users WHERE username='$username' OR email='$email'");
      if ($select->rowCount() > 0) {
        header('Location: ./gallery.php?alert=userAlreadyExist');
        exit();
      }

      //send mail verification
      $cle = md5(microtime(TRUE)*100000);

      $message = 'Bienvenue sur Camagru,

                  Pour activer votre compte, veuillez cliquer sur le lien ci dessous
                  ou copier/coller dans votre navigateur internet.

                  http://localhost:8080/Camagru/user.php?action=mailVerification&username='.$username.'&cle='.$cle.'

                  ---------------
                  Ceci est un mail automatique, Merci de ne pas y répondre.';


      mail($email, "Email by Camagru", $message, "Euh...");

      $db->query("INSERT INTO users (username, password, email, activated) VALUES ('$username', '$password', '$email', '$cle')");

      header("Location: ./gallery.php?alert=userCreated");
      exit();
    }
  }

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

 ?>
