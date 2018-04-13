 
<?php
session_start();
$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("Pøipojení k MYSQL databázi selhalo, chyba: " . $conn->connect_error);
}
header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";


if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>Pøihlášený uživatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav úètu: ". $row['accountBalance'] . " PoodleCoinù.</div>" ;	
} else { echo "<div class='status'> Uživatel nepøihlášen. </div>" ;	}  
?>
<head>
<title>Poodle: Pøihlášení</title>
<div class="menu">
  <a href="index.php">STAHOVÁNÍ</a>
  <a href="upload.php">NAHRÁVÁNÍ</a>
  <a class="active" href="login.php">PØIHLÁŠENÍ</a>
  <a href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHATŠÍ</a>
  <a href="burza.php">BURZA</a>
  <?php
  if (isset($_SESSION['username'])){
  echo "<a class='logout' href='logout.php'>ODHLÁSIT SE</a>" ;
  } 
  if (isset($_SESSION['username'])){
    if($_SESSION['isadmin'] != 0){
      echo "<a href='admin.php'>ADMIN</a>" ;
      }
  }
  ?>
</div>



 
<style>
.menu a.logout {
    float: right;
    }
/* Add a black background color to the top navigation */
.a  {
    font-size: 100px;
}
.menu {
    background-color: #891cb7;
    overflow: hidden;
}


.status {
    text-align: right;
    padding: 5px;
}

/* Style the links inside the navigation bar */
.menu a {
    float: left;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    font-family: "Verdana", Helvetica, sans-serif;
}

/* Change the color of links on hover */
.menu a:hover {
    background-color: #9c63b5; 
    color: white;
}

/* Add a color to the active/current link */
.menu a.active {
    background-color: #53146e;
    color: white;  
}

.logo {
    text-align: center;
    }

</style>
<?php
echo "<p>";
  echo '<div class="logo"><img src="graphics/login.png" alt="Stahovani souboru"></div>';
  echo "<p>";
echo "<p>";
echo "Jste již pøihlášen";
echo "<p>";

if (isset($_POST["submit"])) {
  session_unset();
  header("Location: login.php");
  die;

}
?>
<form action="" method="post"/>
<input type="submit" name="submit" value="Odhlásit se"/>
</form>
<?php


?>
</head>
