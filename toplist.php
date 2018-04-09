<?php
session_start();
$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("Pøipojení k MYSQL databázi selhalo, chyba: " . $conn->connect_error);
}

header("Content-Type: text/html; charset=windows-1250");



echo " <a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a>";


if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>Pøihlášený uživatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav úètu: ". $row['accountBalance'] . " PoodleCoinù.</div>" ;	
} else { echo "<div class='status'> Uživatel nepøihlášen. </div>" ;	}  
?>
<head>
<title>Poodle: Nejbohatší</title>
<div class="menu">
  <a href="index.php">STAHOVÁNÍ</a>
  <a href="upload.php">NAHRÁVÁNÍ</a>
  <a href="login.php">PØIHLÁŠENÍ</a>
  <a href="join.php">REGISTRACE</a>
  <a class="active" href="toplist.php">NEJBOHATŠÍ</a>
</div>
<p>

<style>
/* MENU CSS */

.status {
    text-align: right;
    padding: 5px;
}

.a  {
    font-size: 100px;
}
.menu {
    background-color: #891cb7;
    overflow: hidden;
}


.menu a {
    float: left;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
    font-family: "Verdana", Helvetica, sans-serif;
}


.menu a:hover {
    background-color: #9c63b5; 
    color: white;
}


.menu a.active {
    background-color: #53146e;
    color: white;  
}

.titles {
    font-size: 25px;
    font-family: "Verdana", Helvetica, sans-serif;
    border-bottom: 1px solid; 
    border-bottom-color: #A1A1A1;  
    }
    
/* KONEC MENU CSS */


</style>

</head>


<?php


echo "<font size='18'>";
echo 'Žebøíèek nejbohatších';
echo "</font>";
echo "<p>";
/** všimnìme si že jsou odstranìni admini**/
$sql = "SELECT username, accountbalance FROM poodle.userlogininformation WHERE isadmin = 0 ORDER BY accountbalance DESC;" ;
$result = $conn->query($sql);
$count = mysqli_num_rows($result);

$row = $result->fetch_array(MYSQLI_ASSOC);
echo  "1. <font size=5 color= 'purple'>". $row['username'] . "</font> , se stavem úètu: " . $row['accountbalance'] . " PoodleCoinù. <br>";

for($i = 2; $i <= $count; $i++)
  {
  $row = $result->fetch_array(MYSQLI_ASSOC);
  echo $i . ". ". $row['username'] . " , se stavem úètu: " . $row['accountbalance'] . " PoodleCoinù. <br>";
  }

