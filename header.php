<?php session_start();

  include('config/database.php');
  // include('user.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Camagru</title>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/mounting.css">
        <link rel="stylesheet" href="css/gallery.css">
        <link rel="stylesheet" href="css/user.css">
        <link rel="stylesheet" href="css/footer.css">
    </head>
    <body>
        <header>
            <div id="header">
                <p id="title" class="police">Camagru</p>
                <div id="login">
                  <?php if ($_SESSION['username']): ?>
                    <a href="user.php?action=logout">Log out</a>
                    <a href="mounting.php">mounting</a>
                    <a href="gallery.php">gallery</a>
                  <?php else: ?>
                    <!-- Sign in pop up -->
                    <div class="popup">
                      <button id="myBtnSi" class="btn">Sign in</button>
                      <div id="myPopup" class="popuptext">
                        <form method="POST" action="./user.php">
                          <p>Username</p>
                          <input type="text" name="username" value="">
                          <p>Password</p>
                          <input type="text" name="password" value=""><br>
                          <a id="myLink" href="javascript:void(0);">Forgot your password ?</a><br>
                          <input type="submit" name="ok" value="Sign in">
                        </form>
                      </div>
                    </div>
                    <!-- missing password modal -->
                    <div id="myModal_pwd" class="modal">
                      <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 id="form_top" class="police">Get a new password</h1><br>
                        <form method="POST" action="./user.php">
                          <p>Enter your mail adress:</p>
                          <input type="text" name="mail" value="">
                          <input type="submit" name="action" value="Send the request">
                        </form>
                      </div>
                    </div>
                    <!-- Register in modal -->
                    <button id="myBtnRe" class="btn">Register</button>
                    <div id="myModal" class="modal">
                      <div class="modal-content">
                        <span class="close">&times;</span>
                        <h1 id="form_top" class="police">Create account</h1><br>
                        <form method="POST" action="./user.php">
                          <p>Username:</p>
                          <input type="text" name="username" value="">
                          <p>Password:</p>
                          <input type="text" name="password" value="">
                          <p>Re-enter password:</p>
                          <input type="text" name="re-password" value="">
                          <p>Email:</p>
                          <input type="text" name="email" value=""><br>
                          <input type="submit" name="ok" value="Create your account">
                        </form>
                      </div>
                    </div>
                    <script src="js/header.js"></script>
                  <?php endif; ?>
                </div>
            </div>
        </header>
