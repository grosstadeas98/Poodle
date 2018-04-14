
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

$sql = "SELECT accountBalance,isadmin FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
if (isset($_SESSION['username'])) {
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

</style>
<?php
echo "<p>";
echo '<div class="logo"><img src="graphics/burza.png" alt="Stahovani souboru"></div>';
echo "<p>";

if(isset($_SESSION['username']) != TRUE){
echo "<p>Pro smazání inzerátu se pøihlašte. ";
die;
}



$idBurza = htmlspecialchars($_GET['id']);

$sqlBurza = "SELECT authorid FROM poodle.burza WHERE id=" . $idBurza . ";";
$resultBurza = $conn->query($sqlBurza);
$rowBurza = $resultBurza->fetch_array(MYSQLI_ASSOC);

$autor = $rowBurza['authorid'];

 
if( $_SESSION['id'] == $autor or $row['isadmin'] == 1){
  $sqlDelete = "DELETE FROM poodle.burza WHERE id=" . $idBurza . ";";
  if($conn->query($sqlDelete)){
    echo "<p>Inzerát byl smazán v poøádku. ";
  }else{
  echo "<p>Nìkde se stala chyba. ";
  }
  
} else {
  echo "<p>Pouze autor mùže mazat svùj inzerát. ";
}



?>
