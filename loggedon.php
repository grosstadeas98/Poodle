 
<?php
session_start();
header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";

if (isset($_SESSION['username'])) {
  echo "<div class='status'>Pøihlášený uživatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav úètu: ". $_SESSION["balance"] . "</div>" ;	
} else { echo "<div class='status'> Uživatel nepøihlášen. </div>" ;	} 
?>
<head>
<div class="menu">
  <a href="index.php">STAHOVÁNÍ</a>
  <a href="upload.php">NAHRÁVÁNÍ</a>
  <a class="active" href="login.php">PØIHLÁŠENÍ</a>
  <a href="join.php">REGISTRACE</a>
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
<?php
echo "<p>";
echo "Jste již pøihlášen";
echo "<p>";

if (isset($_POST["submit"])) {
  session_unset();
  header("Location: login.php");
  die;

}
?>
<form action="" method="post"/>
<input type="submit" name="submit" value="Odhlásit se"/>
</form>
<?php


?>
</head>
