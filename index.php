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


/* FUNKCE PRO V�PIS SOUBOR� */

function PrintFiles($useddir, $location, $db) {
    for ($i = 2; $i < count($useddir); $i++) {
        $sqlAI = "SELECT authorid FROM poodle.uploaded WHERE filename = '" . $useddir[$i] . "';";
        $resultAI = $db->query($sqlAI);
        $rowAI = mysqli_fetch_array($resultAI,MYSQLI_ASSOC);
        $sqlName = "SELECT username FROM poodle.userlogininformation WHERE id = ". $rowAI['authorid'] . ";";
        $resultName = $db->query($sqlName);
        $rowName = mysqli_fetch_array($resultName,MYSQLI_ASSOC);
        echo("<p><a href='./download.php?filename=". $location . "/" . $useddir[$i] . "&file=" . $useddir[$i] . "' > " . $useddir[$i] . "</a> , Autor souboru: " . $rowName['username'] . ", Cena souboru: 25 PoodleCoin�.") ;
}}

function MakeDir($folder)   {
    return scandir('./uploaded/'. $folder);
}

/* SKENOV�N� SLO�EK */
$cejdir = MakeDir("cej");
$anjdir = MakeDir("anj");
$matdir = MakeDir("mat");
$nejdir = MakeDir("nej");
$ekodir = MakeDir("eko");
$posdir = MakeDir("pos");
$tvydir = MakeDir("tvy");
$paddir = MakeDir("pad");
$grwdir = MakeDir("grw");
$autdir = MakeDir("aut");
$ciscodir = MakeDir("cisco");
$prcdir = MakeDir("prc");
$opsdir = MakeDir("ops");
$aswdir = MakeDir("asw");
$otherdir = MakeDir("other");

echo "<font size='18'>";
echo 'Stahov�n� soubor�';
echo "</font>";
echo "<p>";

/* V�PIS JEDNOTLIV�CH KATEGORI� */
echo "<div class='titles'>�esk� Jazyk</div>"; 
PrintFiles($cejdir,"cej", $conn);

echo "<div class='titles'>Anglick� Jazyk</div>";
PrintFiles($anjdir,"anj", $conn);

echo "<div class='titles'>Matematika</div>";
PrintFiles($matdir,"mat", $conn);

echo "<div class='titles'>N�meck� jazyk</div>";
PrintFiles($nejdir,"nej", $conn);

echo "<div class='titles'>Ekonomika   </div>";
PrintFiles($ekodir,"eko", $conn);

echo "<div class='titles'>Po��ta�ov� s�t�    </div>";
PrintFiles($posdir,"pos", $conn);

echo "<div class='titles'>Technick� vybaven�   </div>";
PrintFiles($tvydir,"tvy", $conn);

echo "<div class='titles'>Programov�n� a datab�ze </div>";
PrintFiles($paddir,"pad", $conn);

echo "<div class='titles'>Grafika a webdesign </div>";
PrintFiles($grwdir,"grw", $conn);

echo "<div class='titles'>Automatizace  </div>";
PrintFiles($autdir,"aut", $conn);

echo "<div class='titles'>Cisco     </div>";
PrintFiles($ciscodir,"cisco", $conn);

echo "<div class='titles'>Praktick� cvi�en�  </div>";
PrintFiles($prcdir,"prc", $conn);

echo "<div class='titles'>Opera�n� syst�my  </div>";
PrintFiles($opsdir,"ops", $conn);

echo "<div class='titles'>Aplika�n� software  </div>";
PrintFiles($aswdir,"asw", $conn);

echo "<div class='titles'>Ostatn�/neuvedeno   </div>";
PrintFiles($otherdir,"other", $conn);

echo "<p>";




?>

