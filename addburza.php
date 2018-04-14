
<?php
session_start();
$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("P�ipojen� k MYSQL datab�zi selhalo, chyba: " . $conn->connect_error);
}

header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";

if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>P�ihl�en� u�ivatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav ��tu: ". $row['accountBalance'] . " PoodleCoin�.</div>" ;	
} else { echo "<div class='status'> U�ivatel nep�ihl�en. </div>" ;	}  


?>



<head>
<title>Poodle: Burza</title>
<div class="menu">
  <a href="index.php">STAHOV�N�</a>
  <a href="upload.php">NAHR�V�N�</a>
  <a href="login.php">P�IHL��EN�</a>
  <a href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHAT��</a>
  <a class="active" href="burza.php">BURZA</a>
  <?php
  if (isset($_SESSION['username'])){
  echo "<a class='logout' href='logout.php'>ODHL�SIT SE</a>" ;
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
echo "<p>Tato str�nka je pouze pro p�ihl�en� u�ivatele!";
die;
}
echo "<p>";
echo '<div class="logo"><img src="graphics/burza.png" alt="Stahovani souboru"></div>';
echo "<p>";

?>

<div class="printout">
<form action="addburza.php" method="post">
N�zev prod�van� u�ebnice:<br> <input id="namebox" type="text" name="name"><p>
Popis:<br>  <input id="textbox" type="text" name="text" ><p>
Kontakt na prodejce:<br>  <input id="contactbox" type="text" name="contact" ><p>
<input type="submit" name="submit" value="Odeslat">


</form>
Za um�st�n� u�ebnice na burzu v�m bude str�eno 100 PoodleCoin�.

<?php


?>



</head>

<?php
if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $text = $_POST['text'];
  $contact = $_POST['contact'];
  
  if(strlen($name) < 5 or strlen($contact) < 5 or strlen($text) < 5 or strlen($name) > 100 or strlen($text) > 500 or strlen($contact) > 100){
    echo "<p> ��dn� pole nesm� b�t pr�zdn� nebo krat�� ne� 5 znak� nebo del�� ne� 100 znak� (V�jma popisu, kter� je max. 500).";
    
  }else{
    $sql = "SELECT id, accountbalance FROM poodle.userlogininformation WHERE id = ". $_SESSION['id'] . ";"; 
    $result = $conn->query($sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if($row['accountbalance'] < 100){
      echo "<p> Nem�te dostatek PoodleCoin� na p�id�n� u�ebnice do burzy. ";
    }
    else{
      $paid = $row['accountbalance'] - 100;
      $sqlPaid = "UPDATE poodle.userlogininformation SET accountbalance = " . $paid . " WHERE id = " . $_SESSION['id'] . ";";
        if($conn->query($sqlPaid)){
          $sqlBurza = "INSERT INTO poodle . burza (name, description, contact, authorid) VALUES ('" . $name . "','" . $text . "','" . $contact . "'," . $_SESSION['id'] . ");";
          if($conn->query ($sqlBurza)){
            echo "<p>�sp�n� jste p�idal u�ebnici do burzy!";
          } else {
            echo "<p>N�kde se stala chyba.";
          }
          
          }
        else{                                               
          echo "Nepoda�ilo se ode��st PoodleCoiny z va�� pen�enky. ";
          }
    }
    
  }
}
?>
</div>