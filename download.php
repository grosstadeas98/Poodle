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

if(file_exists("./uploaded/") !== True) {
  echo "<a href='startup.php'> Setup </a>";


}

if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>P�ihl�en� u�ivatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav ��tu: ". $row['accountBalance'] . " PoodleCoin�.</div>" ;	
} else { echo "<div class='status'> U�ivatel nep�ihl�en. </div>" ;	}  
?>
<head>

<title>Poodle</title>
<div class="menu">
  <a class="active" href="index.php">STAHOV�N�</a>
  <a href="upload.php">NAHR�V�N�</a>
  <a href="login.php">P�IHL��EN�</a>
  <a href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHAT��</a>
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
<p>

<style>
/* MENU CSS */
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
if (isset($_SESSION['username']) != TRUE) {
echo "Pro sta�en� soubor� mus�te b�t p�ihl�en!";
die; 
}
?>
<form action="" method="post">
Jste si jist�, �e chcete st�hnout soubor: <?php echo "<font color='purple'>" . $_GET['filename'] . "</font>" ?> za 25 PoodleCoin�? <p>
<input type ="submit" name="submit" value="Ano">
</form>
<?php
if (isset($_POST['submit'])) {
  $sql = "SELECT accountbalance FROM poodle.userlogininformation WHERE id = " . $_SESSION['id'] . ";";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  $paid = $row['accountbalance'] - 25;
  $sqlPaid = "UPDATE poodle.userlogininformation SET accountbalance = " . $paid . " WHERE id = " . $_SESSION['id'] . ";";
  if($conn->query($sqlPaid)){
      $redirect = "godownload.php?fileloc=" . $_GET['filepath'] . "&file=" . $_GET['filename'];
      header("Location: ". $redirect);
      }
  else{                                               
    echo "Nepoda�ilo se ode��st PoodleCoiny z va�� pen�enky. ";
  }
}
?>
