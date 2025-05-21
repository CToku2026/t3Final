<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Product Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if(array_key_exists("username", $_SESSION) && $_SESSION["username"] != "" && $_SESSION["loginData"] == true){
          $un = $_SESSION["username"];
          $loggedIn = $_SESSION["loginData"];
          $sql = "SELECT * FROM users JOIN userCart ON users.username = '$un' AND users.userId = userCart.userId JOIN cartItem ON userCart.cartId = cartItem.cartId";
          $statement = $conn -> query($sql);
          $cartItems = $statement -> rowCount();
          print
          "<div class='topnav'>
            <a href='index.php' class='active'>Racing Essentials Store</a>
            <div id='links'>
              <a href='index.php'>Hello, ".ucFirst($un)."</a>
              <a href='cart.php'>Cart: ".$cartItems."</a>
              <a href='logout.php'>Logout</a>
            </div>
            <a href='javascript:void(0);' class='icon' onclick='dropDown()''>
              <i class='fa fa-bars'></i>
            </a>
          </div>";
        } else {
          $loggedIn = false;
          $un = "Guest";
          print
          "<div class='topnav'>
            <a href='index.php' class='active'>Racing Essentials Store</a>
            <div id='links'>
              <form method='get' action='searchPage.php'>
                <button type='submit'><i class='fa fa-search'></i></button>
                <input type='text' class='topNavSearchBar' name='searchQuery' placeholder='Search...'>
              </form>
              <a href='index.php'>Hello, ".ucFirst($un)."</a>
              <a href='userCreate.php'>Sign Up</a>
              <a href='login.php'>Login</a>
              <a href='cart.php'>Cart</a>
            </div>
            <a href='javascript:void(0);' class='icon' onclick='dropDown()''>
              <i class='fa fa-bars'></i>
            </a>
          </div>";
        }

        $id = $_GET["product"];

        $sql = "SELECT * FROM items WHERE itemId = '$id'";
        $statement = $conn -> query($sql);

        $statement = $statement -> fetch();
        print "<div class='itemAssets'>";
        print "<img src='images/".$statement["image"]."' width='200'>";

        print "<div class='itemVal'>";
        print "<div class='itemName'>".$statement["name"]."</div>";
        print "<div class='itemPrice'>$".$statement['price']."</div>";

        $sId = $_POST["stores"];

        $storeChosen = false;
        if($sId != ""){
          $storeChosen = $_POST["sChosen"];
        }

        if($storeChosen == ""){
          print "
            <div class='itemDesc'>

            <form method='post'>
            <label for='store'>Choose a store:</label>
            <br>
            <input type='radio' id='utah' name='stores' value='1'>
            <label for='utah'>Utah</label><br>
            <input type='radio' id='virginia' name='stores' value='2'>
            <label for='virginia'>Virgina</label><br>
            <input type='hidden' name='sChosen' value='true'>
            <input type='submit' value='Check Stock'>
            </form>
            </div>
          ";
        }

        $sql = "SELECT * FROM itemStore WHERE storeId = '$sId' AND itemId = '$id'";
        $stock = $conn -> query($sql);
        $stock = $stock -> fetch();
        if($stock["quantity"] > 0){
          print "
          <div class='itemCount'>".$stock["quantity"]." left in stock</div>";
        }


        if($_SESSION["username"] != "" && $_SESSION["loginData"] == true){
          print "
            <form action='cart.php' method='post'>
              <input type='hidden' name='itemId' value='".$id."'>
              <input type='hidden' name='username' value='".$un."'>
              <input type='hidden' name='storeId' value='".$sId."'>";
          if ($storeChosen != ""){
            print "<input type='submit' value='Add to Cart' class='itemButton'>";
          }else{
            print "<div class='itemPrice'>Please choose location</div>";
          }
          print "</form>";
          $sql = "SELECT * FROM userCart JOIN users ON userCart.userId = users.userId AND users.username = '$un'";
          $statement = $conn -> query($sql);
          $userCart = $statement -> fetch();
          $count = $statement -> rowCount();
          if($count == 0){
            $unId = get_id($un, $conn);
            $sql = "INSERT INTO userCart (userId) VALUES ('$unId')";
            $conn -> exec($sql);
          }
        } else {
          if ($storeChosen != ""){
            print "<a href='login.php' class='itemButtonFalse'>Add to Cart</a>";
          }else{
            print "<div class='itemPrice'>Please choose location</div>";
          }
        }
        $sql = "SELECT * FROM items WHERE itemId = '$id'";
        $statement = $conn -> query($sql);

        $statement = $statement -> fetch();
        print "<div class='itemDesc'>".$statement["description"]."</div>";
        print "</div>";
        print "</div><br>";
      }
      catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }

      function get_id($name, $conn){
        $sql = "SELECT userId FROM users WHERE username='$name'";
        $statement = $conn -> query($sql);
        $row = $statement -> fetch();
        return $row["userId"];
      }
    ?>
    <script src="script.js">
    </script>
  </body>
</html>
