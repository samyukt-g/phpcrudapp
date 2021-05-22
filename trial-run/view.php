<?php
session_start();
if  ( ! isset($_SESSION['name'])) { die('Not logged in'); }
require_once('pdo.php');

$name = $_SESSION['name'];

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Samyukt G - View.php</title>
  </head>
  <body>
    <h1>Tracking autos for <?php echo $name; ?></h1>
    <?php 
      if (isset($_SESSION['success'])) {
          echo ('<p style="color:green">' . $_SESSION['success'] . '</p>');
          unset($_SESSION['success']);
      }
    ?>
    <h2>Automobiles</h2>
    <ul>
      <?php
          $SELECTALL = $pdo->query("SELECT * FROM Autos");
          while ($row = $SELECTALL->fetch(PDO::FETCH_ASSOC)) {
            echo '<li>' . htmlentities($row['year']) . ' ' . htmlentities($row['make']) . ' / ' . htmlentities($row['mileage']) . '</li>';
          }
      ?>
    </ul>
    <p><a href="add.php">Add New</a> | <a href="logout.php">Logout</a></p>
  </body>
</html>
