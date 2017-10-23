<?php include('header.php'); ?>

<div id="montage">
  <video id="video"></video>
  <button id="startbutton">Take photo</button>
  <div class="">
    <canvas id="canvas"></canvas>
    <button id="myBtn" type="button" name="button">Save</button>
  </div>

  <form id="myForm" action="savePicture.php" method="POST">
    <input id="myInput" type="hidden" name="data" value="">
    <input type="radio" name="filter" value="Yoshi" checked><img class="filter" src="filter/Yoshi.png" alt="Yoshi">
    <input type="radio" name="filter" value="Mario"><img class="filter" src="filter/Mario.png" alt="Mario">
    <input type="radio" name="filter" value="Grass"><img class="filter" src="filter/Grass.png" alt="Grass">
    <input type="radio" name="filter" value="Degrad"><img class="filter" src="filter/Degrad.png" alt="Degrad">
  </form>

  <form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
    <input type="radio" name="filter" value="Yoshi" checked><img class="filter" src="filter/Yoshi.png" alt="Yoshi">
    <input type="radio" name="filter" value="Mario"><img class="filter" src="filter/Mario.png" alt="Mario">
    <input type="radio" name="filter" value="Grass"><img class="filter" src="filter/Grass.png" alt="Grass">
    <input type="radio" name="filter" value="Degrad"><img class="filter" src="filter/Degrad.png" alt="Degrad">
  </form>
  <!-- delete picture -->
  <form id="delete" action="delPicture.php" method="POST">
    <input id="delInput" type="hidden" name="delete" value="">
  </form>
</div>

<div id="gallery">

  <?php
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->exec("USE $DB_NAME;");

    $username = $_SESSION['username'];
    $request = $db->query("SELECT id FROM users WHERE username='$username'");
    $user_id = $request->fetch();

    $request = $db->query("SELECT COUNT(id) FROM images WHERE user_id='$user_id[0]'");
    $nbrImage = $request->fetch();
    $perPage = 8;
    $nbPage = ceil($nbrImage[0] / $perPage);

    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $nbPage) {
      $cPage = addslashes($_GET['page']);
    } else {
      $cPage = 1;
    }

    $request = $db->query("SELECT * FROM images WHERE user_id='$user_id[0]' LIMIT ".(($cPage - 1) * $perPage).", ".$perPage."");
    $images = $request->fetchAll();
    foreach ($images as $key => $value) {
      echo '<img class="photo" src="'.$value[1].'" alt="photo" onclick="delPicture('.$value[0].')">';
    }

    for ($i = 1; $i <= $nbPage; $i++) {
      echo "<a href=\"mounting.php?page=".$i."\">".$i." / </a>";
    }

    ?>

</div>

<script src="js/mounting.js"></script>

<?php include('footer.php'); ?>
