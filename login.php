 
<?php
session_start();

header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";
?>
<head>
<div class="menu">
  <a href="index.php">STAHOVÁNÍ</a>
  <a href="upload.php">NAHRÁVÁNÍ</a>
  <a class="active" href="login.php">PØIHLÁŠENÍ</a>
  <a href="join.php">REGISTRACE</a>
</div>

 <p>
PØIHLÁŠENÍ
 <p>
<form id="login" action="login.php" method="post">
<input type="hidden" name="submitted" id="submitted" value="1">
Vaše pøihlašovací jméno:
<input type="text" name="name" id="name" maxlenght ="50">
 <p>
Vaše heslo:
<input type="password" name="pass" id="pass" maxlenght ="20">
 <p>
 <input type="submit" name="submit" value="Potvrdit">
</form>

<style>
/* Add a black background color to the top navigation */
.a  {
    font-size: 100px;
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

</style>
<?php
if (isset($_SESSION["username"])) {
  header("Location: loggedon.php");
  die;
  }


$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("Pøipojení k MYSQL databázi selhalo, chyba: " . $conn->connect_error);
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
    $sql = "SELECT id FROM poodle.userlogininformation WHERE username = '" . htmlspecialchars($input_login) . "' and passwordHash = '$resultHash';";
    /**echo $sql;**/
    $resultFinal = $conn->query($sql);
    $countFinal = mysqli_num_rows($resultFinal);
    $rowFinal = mysqli_fetch_array($result,MYSQLI_ASSOC);
    
    if($countFinal == 1){
       $_SESSION["username"] = $input_login;
       $_SESSION["passwordHash"] = $resultHash; 
    }
    else{
      echo "Zadal jste špatné uživatelské jméno nebo heslo.";    
    }    
  }else{
    echo "Zadal jste špatné uživatelské jméno nebo heslo.";
}

}

?>


</head>
