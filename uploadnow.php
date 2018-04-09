<?php
session_start();
header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";
$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("Pøipojení k MYSQL databázi selhalo, chyba: " . $conn->connect_error);
}


if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>Pøihlášený uživatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav úètu: ". $row['accountBalance'] . " PoodleCoinù. </div>" ;	
} else { echo "<div class='status'> Uživatel nepøihlášen. </div>" ;	}  
?>
<head>
<title>Poodle: Nahrávání</title>
<div class="menu">
  <a href="index.php">STAHOVÁNÍ</a>
  <a class="active" href="upload.php">NAHRÁVÁNÍ</a>
  <a href="login.php">PØIHLÁŠENÍ</a>
  <a href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHATŠÍ</a>
</div>
<style>
/* Add a black background color to the top navigation */
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
echo "<font size='18'>";
echo 'Nahrávání souborù';
echo "</font>";
echo "<p>";


$target_dir = "uploaded/";
$target_file = $target_dir . $_POST["cathegory"] . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$loadedOk = 1;
$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if(isset($_POST["submit"])) {
    $check = filesize($_FILES["fileToUpload"]["tmp_name"]);   
    if($check !== false) {
        echo "Soubor naèten v poøádku" . $check["mime"] . ".";
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
    echo "Omlouváme se, ale váš soubor nemùžeme nahrát.";

} 
elseif ($uploadOk == 2) {
    echo "<p>";
    echo "Soubor již existuje.";
    echo "<p>";
    echo "Omlouváme se, ale váš soubor nemùžeme nahrát.";
}
elseif ($uploadOk == 3) {
    echo "<p>";
    echo "Váš soubor má pøíliš vysokou velikost (<5MB)";
    echo "<p>";
    echo "Omlouváme se, ale váš soubor nemùžeme nahrát.";
}
elseif ($uploadOk == 4) {
    echo "<p>";
    echo "Váš soubor má nepodporovaný formát. Podoporované: PNG,JPG,JPEG,DOCX,TXT,PDF,RTF";
    echo "<p>";
    echo "Omlouváme se, ale váš soubor nemùžeme nahrát.";
}
else {
    $sql = "INSERT INTO poodle . uploaded (fileName, authorid) VALUES ('" . htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])) . "', " . $_SESSION['id'] . ");";
    if($conn->query($sql)){
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "<p>";
          echo "Váš soubor ". basename( $_FILES["fileToUpload"]["name"]). " byl úspìšnì nahrán na server. Za nahrání souboru jste byl obmìnìn 75 PoodleCoinama. Dìkujeme!";
          $rewarded = $row['accountBalance'] + 75;
          $sqlReward = "UPDATE poodle.userlogininformation SET accountbalance = " . $rewarded . " WHERE id = " . $_SESSION['id'] . ";";
          $conn->query($sqlReward);
          }
        else {
          echo "<p>";
          echo "Omlouváme se, ale nastala chyba pøi nahrávání vašeho souboru.";
          $sqlDel = "DELETE FROM poodle.uploaded WHERE filename = '" . htmlspecialchars(basename( $_FILES["fileToUpload"]["name"])) . "';";
          $conn->query($sqlDel);
        }
    } else {
        echo "<p>";
        echo "Omlouváme se, ale nastala chyba pøi nahrávání záznamu o vašem souboru do databáze.";

    }
}

?>    



<!DOCTYPE html>
<html>
<body>

<form action="upload.php" method="post">
    <input type="submit" value="Zpìt" name="aaaaaaa">
</form>

</body>
</html>         