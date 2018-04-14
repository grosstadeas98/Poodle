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
<title>Poodle: Admin sekce</title>
<div class="menu">
  <a href="index.php">STAHOV�N�</a>
  <a href="upload.php">NAHR�V�N�</a>
  <a href="login.php">P�IHL��EN�</a>
  <a href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHAT��</a>
  <a href="burza.php">BURZA</a>

  <?php
  if (isset($_SESSION['username'])){
  echo "<a class='logout' href='logout.php'>ODHL�SIT SE</a>" ;
  } 

  ?>
  <a class="active" class="logout" href="admin.php">ADMIN</a>
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
    
/* KONEC MENU CSS */


</style>

</head>


<?php
if(isset($_SESSION['username']) != TRUE){
  echo "Tato str�nka je pouze pro p�ihl�en� u�ivatele! <p>";
  die;
}

if($_SESSION['isadmin'] == 0){
  echo "Tato str�nka je ur�en� pro administr�tory str�nky! <p>";
  die;
}

$sql = "SELECT id, username, firstLastName, email, accountbalance, isadmin, isbanned FROM poodle.userlogininformation WHERE isadmin = 0;" ;
$result = $conn->query($sql);
$count = mysqli_num_rows($result);

echo "SPR�VA U�IVATEL� <p>";

for($i = 1; $i <= $count; $i++)
  {
  $row = $result->fetch_array(MYSQLI_ASSOC);
  if($row['isbanned'] == 0){
    echo $i . ". ID: ". $row['id'] . ", Nick:   " . $row['username'] . ", Jmeno: " . $row['firstLastName'] . ", Stav: " . $row['accountbalance'] . ", Banned: " . $row['isbanned'] . " <a href='ban.php?id=" . $row['id'] . "'>BAN </a><p>";
    } else{
    echo $i . ". ID: ". $row['id'] . ", Nick:   " . $row['username'] . ", Jmeno: " . $row['firstLastName'] . ", Stav: " . $row['accountbalance'] . ", Banned: " . $row['isbanned'] . " <a href='unban.php?id=" . $row['id'] . "'>UNBAN </a><p>";
    }
  }
  


?>

