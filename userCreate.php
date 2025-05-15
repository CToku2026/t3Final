<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sign Up</title>
  </head>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    @import "compass/css3";

    * { box-sizing: border-box; margin: 0; padding:0; }

    html {
      background-image: url(http://subtlepatterns2015.subtlepatterns.netdna-cdn.com/patterns/dark_embroidery.png);
      font-family: 'Helvetica Neue', Arial, Sans-Serif;

      .login-wrap {
        position: relative;
        margin: 100px auto;
        background: #ecf0f1;
        width: 350px;
        border-radius: 5px;
        box-shadow: 3px 3px 10px #333;
        padding: 15px;

        h2 {
          text-align: center;
          font-weight: 200;
          font-size: 2em;
          margin-top: 10px;
          color: #34495e;
        }

        .form {
          padding-top: 20px;

          input[type="text"],
          input[type="password"],
          button {
            width: 80%;
            margin-left: 10%;
            margin-bottom: 25px;
            height: 40px;
            border-radius: 5px;
            outline: 0;
            -moz-outline-style: none;
          }

          input[type="text"],
          input[type="password"] {
            border: 1px solid #bbb;
            padding: 0 0 0 10px;
            font-size: 14px;
            &:focus {
              border: 1px solid #3498db;
            }
          }

          a {
            text-align: center;
            font-size: 10px;
            color: #3498db;

            p{
              padding-bottom: 10px;
            }

          }

          button {
            background: #383838;
            border:none;
            color: white;
            font-size: 18px;
            font-weight: 200;
            cursor: pointer;
            transition: box-shadow .4s ease;

            &:hover {
              box-shadow: 1px 1px 5px #555;
            }

            &:active {
                box-shadow: 1px 1px 7px #222;
            }

          }

        }

        &:after{
        content:'';
        position:absolute;
        top: 0;
        left: 0;
        right: 0;
        background:-webkit-linear-gradient(left,
            #27ae60 0%, #27ae60 20%,
            #8e44ad 20%, #8e44ad 40%,
            #3498db 40%, #3498db 60%,
            #e74c3c 60%, #e74c3c 80%,
            #f1c40f 80%, #f1c40f 100%
            );
           background:-moz-linear-gradient(left,
            #27ae60 0%, #27ae60 20%,
            #8e44ad 20%, #8e44ad 40%,
            #3498db 40%, #3498db 60%,
            #e74c3c 60%, #e74c3c 80%,
            #f1c40f 80%, #f1c40f 100%
            );
          height: 5px;
          border-radius: 5px 5px 0 0;
      }

      }

    }
  </style>
  <body>
    <div class='topnav'>
      <a href='index.php' class='active'>Racing Essentials Store</a>
      <div id='links'>
        <form method='get' action='searchPage.php'>
          <button type='submit'><i class='fa fa-search'></i></button>
          <input type='text' class='topNavSearchBar' name='searchQuery' placeholder='Search...'>
        </form>
        <a href='index.php'>Hello, Guest</a>
        <a href='userCreate.php'>Sign Up</a>
        <a href='login.php'>Login</a>
        <a href='cart.php'>Cart</a>
      </div>
      <a href='javascript:void(0);' class='icon' onclick='dropDown()'>
        <i class='fa fa-bars'></i>
      </a>
    </div>

    <div class="login-wrap">
      <h2>Create Account</h2>

      <div class="form">
        <form action="userCreate.php" method="post">
          <input type="text" name="username" placeholder="Username...">
          <input type="password" name="password" placeholder="Password...">
          <input type="password" name="passwordCheck" placeholder="Password again..">
          <input type="text" name="email" placeholder="email">
          <button type='submit'> Create Account </button>
        </form>
        <a href="login.php"> <p> Have an account? Sign in </p></a>
      </div>
    </div>

    <!-- <form action="userCreate.php" method="get">
      <input type="text" name="username" placeholder="Username...">
      <input type="password" name="password" placeholder="Password...">
      <input type="password" name="passwordCheck" placeholder="Password again..">
      <input type="text" name="email" placeholder="email">
      <input type="submit" value="Create account">
    </form> -->

    <?php


      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbName = "t3Final";

      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);


        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $u = $_POST["username"];
        $p = $_POST["password"];
        $pc = $_POST["passwordCheck"];
        $e = $_POST["email"];

        if($u == "" && $p == "" && $pc == "" && $e == ""){
          return;
        }

        if($u == "" || $p == "" || $pc == "" || $e == ""){
          print "<script type='text/javascript'>alert('Missing parameter');</script>";
          return;
        }

        $sql = "SELECT * FROM users";
        $statement = $conn -> query($sql);

        foreach($statement as $row){
          if($row["username"] == $u){
            print "<script type='text/javascript'>alert('username already exists');</script>";
            return;
          }
          if($row["email"] == $e){
            print "<script type='text/javascript'>alert('Email already in use');</script>";
            return;
          }
        }

        if($p != $pc){
          print "<script type='text/javascript'>alert('passwords do not match');</script>";
          return;
        }

        $sql = "INSERT INTO users (username, password, email) VALUES ('$u', '$p', '$e')";
        $conn -> exec($sql);


        $_SESSION["loginData"] = true;
        $_SESSION["username"] = $un;
        print "<meta http-equiv = 'refresh' content = '1; url = index.php' />";
        exit;

      }


      catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
      }
     ?>
  </body>
</html>
