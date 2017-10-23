<?php

include('database.php');

try {
  $db = new PDO($DB_DSN.";dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
  die("Erreur : Unknown database $DB_NAME");
}

$db->exec("DROP DATABASE $DB_NAME;");
echo "Database $DB_NAME dropped."

?>
