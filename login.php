
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
<p>
<div class="logo"><img src="graphics/login.png" alt="Stahovani souboru"></div>
<p>
<div class="login">
<form id="login" action="login.php" method="post">
<input type="hidden" name="submitted" id="submitted" value="1">
Vaše pøihlašovací jméno: <br>
<input type="text" name="name" id="name" maxlenght ="50">
 <p>
Vaše heslo: <br>
<input type="password" name="pass" id="pass" maxlenght ="20">
 <p>
 <input type="submit" name="submit" value="Potvrdit">
</form>
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
    
.login{
    text-align: center;
}

</style>
<div class="login">
<?php

if (isset($_SESSION["username"])) {
  header("Location: loggedon.php");
  die;
  }






if (isset($_POST['submit'])) {
  $input_login = $_POST['name'];    
  $input_password = $_POST['pass'];

  $sql = "SELECT email FROM poodle.userlogininformation WHERE username = '$input_login';";
  $result = $conn->query($sql);
  $count = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

  if($count == 1){
    $resultHash = md5($input_password . $row['email']);
    $sql = "SELECT accountBalance,isAdmin,id, isBanned FROM poodle.userlogininformation WHERE username = '" . htmlspecialchars($input_login) . "' and passwordHash = '$resultHash';";
    /**echo $sql;**/
    $resultFinal = $conn->query($sql);
    $countFinal = mysqli_num_rows($resultFinal);
    $rowFinal = mysqli_fetch_array($resultFinal,MYSQLI_ASSOC);
    
    if($countFinal == 1){
       if($rowFinal['isBanned'] == 0){
        $accBalance = $rowFinal['accountBalance'];
        $isAdmin = $rowFinal['isAdmin'];
        $accID = $rowFinal['id'];
        echo "Byl jste úspìšnì pøihlášen. Vítej: <font color='purple'> ". $input_login . "</font>!";
        $_SESSION["id"] = $accID;
        $_SESSION["username"] = $input_login;
        $_SESSION["passwordHash"] = $resultHash; 
        $_SESSION["isadmin"] = $isAdmin;
        } else{
        echo "Váš úèet je právì zablokován, pro bližší informace nás kontaktujte. " ;
        }
    }
    else{
      echo "Zadal jste špatné uživatelské jméno nebo heslo.";    
    }    
  }else{
    echo "Zadal jste špatné uživatelské jméno nebo heslo.";
}

}

?>
</div>

</head>
