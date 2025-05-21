<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      body {
        font-family: Arial;
        font-size: 17px;
        padding: 8px;
      }

      * {
        box-sizing: border-box;
      }

      .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin: 0 -16px;
        margin-top: 10px;
      }

      .col-25 {
        -ms-flex: 25%;
        flex: 25%;
      }

      .col-50 {
        -ms-flex: 50%;
        flex: 50%;
      }

      .col-75 {
        -ms-flex: 75%;
        flex: 75%;
      }

      .col-25,
      .col-50,
      .col-75 {
        padding: 0 16px;
      }

      .container {
        background-color: #f2f2f2;
        padding: 5px 20px 15px 20px;
        border: 1px solid lightgrey;
        border-radius: 3px;
      }

      input[type=text] {
        width: 100%;
        margin-bottom: 20px;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 3px;
      }

      label {
        margin-bottom: 10px;
        display: block;
      }

      .icon-container {
        margin-bottom: 20px;
        padding: 7px 0;
        font-size: 24px;
      }

      .btn {
        background-color: #04AA6D;
        color: white;
        padding: 12px;
        margin: 10px 0;
        border: none;
        width: 100%;
        border-radius: 3px;
        cursor: pointer;
        font-size: 17px;
      }

      .btn:hover {
        background-color: #45a049;
      }

      a {
        color: #2196F3;
      }

      hr {
        border: 1px solid lightgrey;
      }

      span.price {
        float: right;
        color: grey;
      }

      @media (max-width: 800px) {
        .row {
          flex-direction: column-reverse;
        }
        .col-25 {
          margin-bottom: 20px;
        }
      }
      </style>
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

        $sql = "SELECT price FROM items JOIN cartItem ON cartItem.cartId = '$cId' AND cartItem.itemId = items.itemId";
        $statement = $conn -> query($sql);
        $priceTotal = 0.00;
        foreach($statement as $row){
          $priceTotal = $row["price"] + $priceTotal;
        }

        if(array_key_exists('clearCheckout', $_POST)) {
            $sql = "SELECT * FROM cartItem WHERE cartItem.cartId = '$cId'";
            $statement = $conn -> query($sql);
            foreach ($statement as $row) {
              $iId = $row["itemId"];
              $sql = "UPDATE itemStore SET quantity = quantity-1 WHERE itemId = '$iId'";
              $conn -> exec($sql);
            }

            $sql = "DELETE FROM userCart WHERE userId = '$unId'";
            $conn -> exec($sql);
            print "<meta http-equiv = 'refresh' content = '0; url = cart.php' />";

        }


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
      <div class="row">
        <div class="col-75">
          <div class="container">
              <div class="row">
                <div class="col-50">
                  <h3>Billing Address</h3>
                  <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                  <input type="text" id="fname" name="firstname" placeholder="John M. Doe">
                  <label for="email"><i class="fa fa-envelope"></i> Email</label>
                  <input type="text" id="email" name="email" placeholder="john@example.com">
                  <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                  <input type="text" id="adr" name="address" placeholder="542 W. 15th Street">
                  <label for="city"><i class="fa fa-institution"></i> City</label>
                  <input type="text" id="city" name="city" placeholder="New York">

                  <div class="row">
                    <div class="col-50">
                      <label for="state">State</label>
                      <input type="text" id="state" name="state" placeholder="NY">
                    </div>
                    <div class="col-50">
                      <label for="zip">Zip</label>
                      <input type="text" id="zip" name="zip" placeholder="10001">
                    </div>
                  </div>
                </div>

                <div class="col-50">
                  <h3>Payment</h3>
                  <label for="fname">Accepted Cards</label>
                  <div class="icon-container">
                    <i class="fa fa-cc-visa" style="color:navy;"></i>
                    <i class="fa fa-cc-amex" style="color:blue;"></i>
                    <i class="fa fa-cc-mastercard" style="color:red;"></i>
                    <i class="fa fa-cc-discover" style="color:orange;"></i>
                  </div>
                  <label for="cname">Name on Card</label>
                  <input type="text" id="cname" name="cardname" placeholder="John More Doe">
                  <label for="ccnum">Credit card number</label>
                  <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                  <label for="expmonth">Exp Month</label>
                  <input type="text" id="expmonth" name="expmonth" placeholder="September">
                  <div class="row">
                    <div class="col-50">
                      <label for="expyear">Exp Year</label>
                      <input type="text" id="expyear" name="expyear" placeholder="2018">
                    </div>
                    <div class="col-50">
                      <label for="cvv">CVV</label>
                      <input type="text" id="cvv" name="cvv" placeholder="352">
                    </div>
                  </div>
                </div>

              </div>
            <form method="post">
              <input type="submit" value="Confirm Order" class="btn" name="clearCheckout">
            </form>
          </div>
        </div>
        <div class="col-25">
          <div class="container">
            <?php
              print "<h4>Cart <span class='price' style='color:black'><i class='fa fa-shopping-cart'></i> <b>".$count."</b></span></h4>";
              $sql = "SELECT * FROM items JOIN cartItem ON items.itemId = cartItem.itemId JOIN userCart ON cartItem.cartId = userCart.cartId AND userCart.userId = '$unId'";
              $statement = $conn -> query($sql);
              foreach($statement as $row){
                print "<p>".$row["name"]."<span class='price'>".$row["price"]."</span></p>";
              }

              $sql = "SELECT price FROM items JOIN cartItem ON cartItem.cartId = '$cId' AND cartItem.itemId = items.itemId";
              $statement = $conn -> query($sql);
              $priceTotal = 0.00;
              foreach($statement as $row){
                $priceTotal = $row["price"] + $priceTotal;
              }
              print "<hr>";
              print "<p>Items:<span class='price' style='color:black'><b>$".$priceTotal."</b></span></p>";
              $taxPrice = round(($priceTotal*7.25)/100, 2);
              print "<p>Tax:<span class='price' style='color:black'><b>$".$taxPrice."</b></span></p>";
              $totalPrice = round($priceTotal + $taxPrice, 2);
              print "<p>Total:<span class='price' style='color:black'><b>$".$totalPrice."</b></span></p>";
            ?>
          </div>
        </div>
      </div>

     <script src="script.js">
     </script>
  </body>
</html>
