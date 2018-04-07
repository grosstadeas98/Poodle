<?php
session_start();

header("Content-Type: text/html; charset=windows-1250");



echo " <a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a>";

if(file_exists("./uploaded/") !== True) {
  echo "<a href='startup.php'> Setup </a>";


}
if (isset($_SESSION['username'])) {
  echo "<div class='status'>Pøihlášený uživatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav úètu: ". $_SESSION["balance"] . "</div>" ;	
} else { echo "<div class='status'> Uživatel nepøihlášen. </div>" ;	} 
?>
<head>
<div class="menu">
  <a class="active" href="index.php">STAHOVÁNÍ</a>
  <a href="upload.php">NAHRÁVÁNÍ</a>
  <a href="login.php">PØIHLÁŠENÍ</a>
  <a href="join.php">REGISTRACE</a>
</div>
<p>

<style>
/* MENU CSS */

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

/* FUNKCE PRO VÝPIS SOUBORÙ */

function PrintFiles($useddir, $location) {
    for ($i = 2; $i < count($useddir); $i++) {
        echo("<p><a href='./uploaded/". $location . "/" . $useddir[$i] . "'> " . $useddir[$i] . "</a>") ;
}}

function MakeDir($folder)   {
    return scandir('./uploaded/'. $folder);
}

/* SKENOVÁNÍ SLOŽEK */
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
echo 'Stahování souborù';
echo "</font>";
echo "<p>";

/* VÝPIS JEDNOTLIVÝCH KATEGORIÍ */
echo "<div class='titles'>Èeský Jazyk</div>"; 
PrintFiles($cejdir,"cej");

echo "<div class='titles'>Anglický Jazyk</div>";
PrintFiles($anjdir,"anj");

echo "<div class='titles'>Matematika</div>";
PrintFiles($matdir,"mat");

echo "<div class='titles'>Nìmecký jazyk</div>";
PrintFiles($nejdir,"nej");

echo "<div class='titles'>Ekonomika   </div>";
PrintFiles($ekodir,"eko");

echo "<div class='titles'>Poèítaèové sítì    </div>";
PrintFiles($posdir,"pos");

echo "<div class='titles'>Technické vybavení   </div>";
PrintFiles($tvydir,"tvy");

echo "<div class='titles'>Programování a databáze </div>";
PrintFiles($paddir,"pad");

echo "<div class='titles'>Grafika a webdesign </div>";
PrintFiles($grwdir,"grw");

echo "<div class='titles'>Automatizace  </div>";
PrintFiles($autdir,"aut");

echo "<div class='titles'>Cisco     </div>";
PrintFiles($ciscodir,"cisco");

echo "<div class='titles'>Praktické cvièení  </div>";
PrintFiles($prcdir,"prc");

echo "<div class='titles'>Operaèní systémy  </div>";
PrintFiles($opsdir,"ops");

echo "<div class='titles'>Aplikaèní software  </div>";
PrintFiles($aswdir,"asw");

echo "<div class='titles'>Ostatní/neuvedeno   </div>";
PrintFiles($otherdir,"other");

echo "<p>";




?>

