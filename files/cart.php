<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
              <form method='get' action='searchPage.php'>
                <button type='submit'><i class='fa fa-search'></i></button>
                <input type='text' class='topNavSearchBar' name='searchQuery' placeholder='Search...'>
              </form>
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
          print "<meta http-equiv = 'refresh' content = '0; url = login.php' />";
          return;
        }

        $un = $_SESSION["username"];


        $unId = get_id($un, $conn);

        $sql = "SELECT * FROM userCart JOIN users ON userCart.userId = users.userId AND users.username = '$un'";
        $statement = $conn -> query($sql);
        $userCart = $statement -> fetch();
        $count = $statement -> rowCount();
        $cId = $userCart["cartId"];
        $iId = $_POST["itemId"];
        $sId = $_POST["storeId"];



        if($count == 0 && $_POST["itemId"] != ""){
          $sql = "INSERT INTO userCart (userId) VALUES ('$unId')";
          $conn -> exec($sql);
          $sql = "INSERT INTO cartItem (cartId, itemId, storeId) VALUES ('$cId', '$iId', '$sId')";
          $conn -> exec($sql);
          print "<meta http-equiv = 'refresh' content = '0; url = cart.php' />";
        }

        if($count == 0){
          $sql = "INSERT INTO userCart (userId) VALUES ('$unId')";
          $conn -> exec($sql);
        }

        if($_POST["itemId"] != ""){
          $sql = "INSERT INTO cartItem (cartId, itemId, storeId) VALUES ('$cId', '$iId', '$sId')";
          $conn -> exec($sql);
          print "<meta http-equiv = 'refresh' content = '0; url = cart.php' />";
        }



        print "<div class='itemCartAssets'>";
        print "<div class='itemCartText'>";

        $sql = "SELECT * FROM items JOIN cartItem ON items.itemId = cartItem.itemId JOIN userCart ON cartItem.cartId = userCart.cartId AND userCart.userId = '$unId'";
        $statement = $conn -> query($sql);
        foreach($statement as $row){
          print "<div class='itemCartName'>".$row["name"]."</div><span class='itemCartPrice' style='color:black'><b>$".$row["price"]."</b></span> ";
          print "<div><hr></div>";
        }

        print "</div>";


        print "<div class='itemCartTally'>";
        if(array_key_exists('cartDelete', $_POST)) {
            $sql = "DELETE FROM userCart WHERE userId = '$unId'";
            $conn -> exec($sql);
            print "<meta http-equiv = 'refresh' content = '0; url = cart.php' />";
        }
        $sql = "SELECT price FROM items JOIN cartItem ON cartItem.cartId = '$cId' AND cartItem.itemId = items.itemId";
        $statement = $conn -> query($sql);
        $priceTotal = 0.00;
        foreach($statement as $row){
          $priceTotal = $row["price"] + $priceTotal;
        }
        print "<div class='itemPrice'>Items: $".$priceTotal."</div>";
        $taxPrice = round(($priceTotal*7.25)/100, 2);
        print "<div class='itemPrice'>Tax: $".$taxPrice."</div>";
        $totalPrice = round($priceTotal + $taxPrice, 2);
        print "<div class='itemPrice'>Total: $".$totalPrice."</div>
          <div>
          <hr>
          </div>
          <div class='itemCartButtons'>
          <div>
          <form action='checkout.php' method='post'>
            <input type='submit' value='Checkout' class='itemButtonCheckout'>
          </form></div>
        </div>
        </div>
        </div>
        <div class='cartDeleteButton'>
        <form method='post' action='cart.php'>
          <input type='submit' name='cartDelete' value='Delete Cart'>
        </form></div>
        ";


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
