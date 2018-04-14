
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
<title>Poodle: Burza</title>
<div class="menu">
  <a href="index.php">STAHOVÁNÍ</a>
  <a href="upload.php">NAHRÁVÁNÍ</a>
  <a href="login.php">PØIHLÁŠENÍ</a>
  <a href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHATŠÍ</a>
  <a class="active" href="burza.php">BURZA</a>
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
/* Add a black background color to the top navigation */
html *
{
   font-size: 17px !important;
   font-family: "Verdana", Helvetica, sans-serif !important;
}


.menu a.logout {
    float: right;
    }

.a  {
    font-size: 100px;
}


.status {
    text-align: right;
    padding: 5px;
}

.menu {
    background-color: #891cb7;
    overflow: hidden;
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

.printout {
    text-align: center;
}

</style>
<?php

if(isset($_SESSION['username']) != TRUE){
echo "<p>Tato stránka je pouze pro pøihlášené uživatele!";
die;
}
echo "<p>";
echo '<div class="logo"><img src="graphics/burza.png" alt="Stahovani souboru"></div>';
echo "<p>";

?>

<div class="printout">
<form action="addburza.php" method="post">
Název prodávané uèebnice:<br> <input id="namebox" type="text" name="name"><p>
Popis:<br>  <input id="textbox" type="text" name="text" ><p>
Kontakt na prodejce:<br>  <input id="contactbox" type="text" name="contact" ><p>
<input type="submit" name="submit" value="Odeslat">


</form>
Za umístìní uèebnice na burzu vám bude strženo 100 PoodleCoinù.

<?php


?>



</head>

<?php
if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $text = $_POST['text'];
  $contact = $_POST['contact'];
  
  if(strlen($name) < 5 or strlen($contact) < 5 or strlen($text) < 5 or strlen($name) > 100 or strlen($text) > 500 or strlen($contact) > 100){
    echo "<p> Žádné pole nesmí být prázdné nebo kratší než 5 znakù nebo delší než 100 znakù (Výjma popisu, který je max. 500).";
    
  }else{
    $sql = "SELECT id, accountbalance FROM poodle.userlogininformation WHERE id = ". $_SESSION['id'] . ";"; 
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($row['accountbalance'] < 100){
      echo "<p> Nemáte dostatek PoodleCoinù na pøidání uèebnice do burzy. ";
    }
    else{
      $paid = $row['accountbalance'] - 100;
      $sqlPaid = "UPDATE poodle.userlogininformation SET accountbalance = " . $paid . " WHERE id = " . $_SESSION['id'] . ";";
        if($conn->query($sqlPaid)){
          $sqlBurza = "INSERT INTO poodle . burza (name, description, contact, authorid) VALUES ('" . $name . "','" . $text . "','" . $contact . "'," . $_SESSION['id'] . ");";
          if($conn->query ($sqlBurza)){
            echo "<p>Úspìšnì jste pøidal uèebnici do burzy!";
          } else {
            echo "<p>Nìkde se stala chyba.";
          }
          
          }
        else{                                               
          echo "Nepodaøilo se odeèíst PoodleCoiny z vaší penìženky. ";
          }
    }
    
  }
}
?>
</div>