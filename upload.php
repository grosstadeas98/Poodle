
<?php
session_start();
header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";
$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("P�ipojen� k MYSQL datab�zi selhalo, chyba: " . $conn->connect_error);
}



if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>P�ihl�en� u�ivatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav ��tu: ". $row['accountBalance'] . " PoodleCoin�. </div>" ;		
} else { echo "<div class='status'> U�ivatel nep�ihl�en. </div>" ;	}  


?>
<head>
<title>Poodle: Nahr�v�n�</title>
<div class="menu">
  <a href="index.php">STAHOV�N�</a>
  <a class="active" href="upload.php">NAHR�V�N�</a>
  <a href="login.php">P�IHL��EN�</a>
  <a href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHAT��</a>
  <a href="burza.php">BURZA</a>
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
.menu a.logout {
    float: right;
    }

.a  {
    font-size: 100px;
}
.menu {
    background-color: #891cb7;
    overflow: hidden;
}


.status {
    text-align: right;
    padding: 5px;
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
</head>
<?php
echo "<p><font size='18'>";
echo 'Nahr�v�n� soubor�';
echo "</font>";

if (isset($_SESSION['username']) != TRUE) {
  echo "<p>";
  echo "Pro nahr�v�n� mus�te b�t p�ihl�en!";
  die;
  }
?>

<!DOCTYPE html>
<html>
<body>

<form action="uploadnow.php" method="post" enctype="multipart/form-data">
    Vyberte do kter� kategorie soubor p�idat:
    <p>
    <select name="cathegory">
      <option value="cej/">�esk� jazyk</option>
      <option value="anj/">Anglick� jazyk</option>
      <option value="mat/">Matematika</option>
      <option value="nej/">N�meck� jazyk</option>
      <option value="eko/">Ekonomika</option>
      <option value="pos/">Po��ta�ov� s�t�</option>
      <option value="tvy/">Technick� vybaven�</option>
      <option value="pad/">Programov�n� a datab�ze</option>
      <option value="grw/">Grafika a webdesign</option>
      <option value="aut/">Automatizace</option>
      <option value="cisco/">CISCO</option>
      <option value="prc/">Praktick� cvi�en�</option>
      <option value="ops/">Opera�n� syst�my</option>
      <option value="asw/">Aplika�n� software</option>
      <option value="other/">Ostatn�/Neuvedeno</option>
    </select>
    <p>
    Vyberte soubor:
    <p>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Nahr�t" name="submit">
  
    
</form>

V�mi nahran� soubory mus� popisovat n�zvem sv�j obsah.
<p>
V�mi nahran� soubory mus� m�t obsah, kter� popisuje jeho n�zev. Z�rove� soubor mus� m�t charakter stud�jn�ho materi�lu.
<p>
Pokud opakovan� poru��te p�edch�zej�c� pravidla, v� ��et bude permanentn� zablokov�n.
</body>
</html>