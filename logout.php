<?php
session_start();
$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("P�ipojen� k MYSQL datab�zi selhalo, chyba: " . $conn->connect_error);
}

header("Content-Type: text/html; charset=windows-1250");



echo " <a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a>";


if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>P�ihl�en� u�ivatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav ��tu: ". $row['accountBalance'] . " PoodleCoin�.</div>" ;	
} else { echo "<div class='status'> U�ivatel nep�ihl�en. </div>" ;	}  
?>
<head>
<title>Poodle: Odhl�en�</title>
<div class="menu">
  <a href="index.php">STAHOV�N�</a>
  <a href="upload.php">NAHR�V�N�</a>
  <a href="login.php">P�IHL��EN�</a>
  <a href="join.php">REGISTRACE</a>
  <a class="active" href="toplist.php">NEJBOHAT��</a>
  <a href="burza.php">BURZA</a>

</div>
<p>

<style>
/* MENU CSS */
html *
{
   font-size: 17px !important;
   font-family: "Verdana", Helvetica, sans-serif !important;
}

.menu a.logout {
    float: right;
    }

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
    
.logo {
    text-align: center;
    }
    
.printout {
    text-align: center;
}
    
/* KONEC MENU CSS */


</style>

</head>

<div class='printout'>
<?php
echo "<p>";
echo '<div class="logo"><img src="graphics/login.png" alt="Stahovani souboru"></div>';
echo "<p>";

if(isset($_SESSION['username']) != TRUE) {
  echo "Nastala chyba";
  die;
}

session_unset();
echo "Nyn� jste odhl�en.";


?>
</div>

