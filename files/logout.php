<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

      session_start();

      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbName = "t3Final";

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // $_SESSION["loginData"];

        $_SESSION["loginData"] = false;
        $_SESSION["username"] = "";

        print "<meta http-equiv = 'refresh' content = '0; url = index.php' />";

      }
      catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
     ?>
  </body>
</html>
