
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
  $sql = "SELECT accountBalance,isadmin FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
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
    
.book {
    border-bottom: 1px solid; 
    border-bottom-color: #A1A1A1;

}

.printout{
    margin-left: 15px;

}

.notlogged{
    text-align: center;
}

</style>
<?php
echo "<p>";
echo '<div class="logo"><img src="graphics/burza.png" alt="Stahovani souboru"></div>';
echo "<p>";

echo  '<div class="notlogged">';
if(isset($_SESSION['username']) != TRUE){
echo "<p>Pro zobrazení burzy se pøihlašte. ";
die;

}
echo '</div>' ;
echo  '<div class="printout">';


?>

<a href="addburza.php">Chci prodat uèebnici!</a>

<p>
<font size = '5'>Aktuální nabídka: </font>
<br>

<?php
$sqlPrint = "SELECT id, name, description, contact, authorid FROM poodle.burza ORDER BY id DESC;" ;
$resultPrint = $conn->query($sqlPrint);
$countPrint = mysqli_num_rows($resultPrint);
$sql = "SELECT accountBalance,isadmin FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

for($i = 1; $i <= $countPrint; $i++){
  $rowPrint = $resultPrint->fetch_array(MYSQLI_ASSOC);
  echo "<p>Pøedmìt: <font color='purple'>" . $rowPrint['name'] . "</font>";
  echo "<p>Popis: " . $rowPrint['description'];
  echo "<p>Kontakt na prodávajícího: " . $rowPrint['contact'];
  $authorID = $rowPrint['authorid'];
  $sqlName = "SELECT username, isadmin FROM poodle.userlogininformation WHERE id = " . $authorID . ";";
  $resultName = $conn->query($sqlName);
  $rowName = $resultName->fetch_array(MYSQLI_ASSOC);
  echo "<div class='book'><p>Autor inzerátu: " . $rowName['username'];
  if($_SESSION['id'] == $authorID or $row['isadmin'] == 1){
  echo "<p><a href='delete.php?id=" . $rowPrint['id'] . "'>Smazat inzerát. </a>";
  }
  echo "</div>";
}
?>
</div>


</head>
