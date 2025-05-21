<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
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
                  <input type='text' name='searchQuery' class='topNavSearchBar' placeholder='Search...'>
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

          $sql = "SELECT * FROM items";
          $statement = $conn -> query($sql);
          print "<div class='options'>";
          foreach($statement as $row){
            print "<a href='itemPage.php?product=".$row["itemId"]."'><div class='itemBox'>";
            print "<div><img src='images/".$row["image"]."' width='40%' style='border: 4px inset black'></div>";
            print "<div><a href='itemPage.php?product=".$row["itemId"]."'>".$row["name"]."</a></div>";
            print "</div></a>";
          }
          print "</div>";

        }
        catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
    ?>
    <script src="script.js">
    </script>
  </body>
</html>
