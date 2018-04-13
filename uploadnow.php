<?php
session_start();
header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";
$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("P¯ipojenÌ k MYSQL datab·zi selhalo, chyba: " . $conn->connect_error);
}


if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>P¯ihl·öen˝ uûivatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav ˙Ëtu: ". $row['accountBalance'] . " PoodleCoin˘. </div>" ;	
} else { echo "<div class='status'> Uûivatel nep¯ihl·öen. </div>" ;	}  
?>
<head>
<title>Poodle: Nahr·v·nÌ</title>
<div class="menu">
  <a href="index.php">STAHOV¡NÕ</a>
  <a class="active" href="upload.php">NAHR¡V¡NÕ</a>
  <a href="login.php">PÿIHL¡äENÕ</a>
  <a href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHATäÕ</a>
  <a href="burza.php">BURZA</a>
  <?php
  if (isset($_SESSION['username'])){
  echo "<a class='logout' href='logout.php'>ODHL¡SIT SE</a>" ;
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
.logo {
    text-align: center;
    }

</style>
</head>
<?php
echo "<p>";
echo '<div class="logo"><img src="graphics/upload.png" alt="Stahovani souboru"></div>';
echo "<p>";


$target_dir = "uploaded/";                          
$target_file = $target_dir . $_POST["cathegory"] . StrTr(basename($_FILES["fileToUpload"]["name"]), "¡ƒ»«œ…ÃÀÕ“”÷ÿäç⁄Ÿ‹›é·‰ËÁÔÈÏÎÌÚÛˆ¯öù˙˘¸˝û", "AACCDEEEINOORSTUUUYZaaccdeeeinoorstuuuyz");
$uploadOk = 1;
$loadedOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if(isset($_POST["submit"])) {
    $check = filesize($_FILES["fileToUpload"]["tmp_name"]);   
    if($check !== false) {
        echo "Soubor naËten v po¯·dku" . $check["mime"] . ".";
        echo "<p>";
        $uploadOk = 1;
        
    } else {
        echo "Nevybrali jste soubor.";
        echo "<p>";
        $loadedOk = 0;
    }
}
if (file_exists($target_file)) {

    $uploadOk = 2; }
    
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    $uploadOk = 3;
}
    
if($fileType != "doc" && $fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "docx" && $fileType != "txt" && $fileType != "pdf" && $fileType != "rtf" ) {
    $uploadOk = 4; }

if ($loadedOk == 0) {
    echo "<p>";
    echo "Omlouv·me se, ale v·ö soubor nem˘ûeme nahr·t.";

} 
elseif ($uploadOk == 2) {
    echo "<p>";
    echo "Soubor jiû existuje.";
    echo "<p>";
    echo "Omlouv·me se, ale v·ö soubor nem˘ûeme nahr·t.";
}
elseif ($uploadOk == 3) {
    echo "<p>";
    echo "V·ö soubor m· p¯Ìliö vysokou velikost (<5MB)";
    echo "<p>";
    echo "Omlouv·me se, ale v·ö soubor nem˘ûeme nahr·t.";
}
elseif ($uploadOk == 4) {
    echo "<p>";
    echo "V·ö soubor m· nepodporovan˝ form·t. PodoporovanÈ: PNG,JPG,JPEG,DOCX,TXT,PDF,RTF";
    echo "<p>";
    echo "Omlouv·me se, ale v·ö soubor nem˘ûeme nahr·t.";
}
else {
    $nameOfFile = StrTr(basename($_FILES["fileToUpload"]["name"]), "¡ƒ»«œ…ÃÀÕ“”÷ÿäç⁄Ÿ‹›é·‰ËÁÔÈÏÎÌÚÛˆ¯öù˙˘¸˝û", "AACCDEEEINOORSTUUUYZaaccdeeeinoorstuuuyz");
    $sql = "INSERT INTO poodle . uploaded (fileName, authorid) VALUES ('" . htmlspecialchars($nameOfFile) . "', " . $_SESSION['id'] . ");";
    if($conn->query($sql)){
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "<p>";
          echo "V·ö soubor ". basename( $_FILES["fileToUpload"]["name"]). " byl ˙spÏönÏ nahr·n na server. Za nahr·nÌ souboru jste byl obmÏnÏn 75 PoodleCoinama. DÏkujeme!";
          $rewarded = $row['accountBalance'] + 75;
          $sqlReward = "UPDATE poodle.userlogininformation SET accountbalance = " . $rewarded . " WHERE id = " . $_SESSION['id'] . ";";
          $conn->query($sqlReward);
          }
        else {
          echo "<p>";
          echo "Omlouv·me se, ale nastala chyba p¯i nahr·v·nÌ vaöeho souboru.";
          $sqlDel = "DELETE FROM poodle.uploaded WHERE filename = '" . htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])) . "';";
          $conn->query($sqlDel);
        }
    } else {
        echo "<p>";
        echo "Omlouv·me se, ale nastala chyba p¯i nahr·v·nÌ z·znamu o vaöem souboru do datab·ze.";

    }
}

?>    



<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post">
    <input type="submit" value="ZpÏt" name="aaaaaaa">
</form>

</body>
</html>         