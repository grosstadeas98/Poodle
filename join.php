<?php
header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";
?>
<head>
<div class="menu">
  <a href="index.php">STAHOVÁNÍ</a>
  <a href="upload.php">NAHRÁVÁNÍ</a>
  <a href="login.php">PØIHLÁŠENÍ</a>
  <a class="active" href="join.php">REGISTRACE</a>
</div>
 <p>
REGISTRACE
 <p>
<form id="register" action="join.php" method="post">
<input type="hidden" name="submitted" id="submitted" value="1">
Vaše jméno a pøíjmení:
<input type="text" name="name" id="name" maxlenght ="50">
 <p>
Vaše emailová adresa:
<input type="text" name="mail" id="mail" maxlenght ="50">
 <p>
Vaše pøihlašovací jméno
<input type="nic" name="nick" id="nick" maxlenght ="15">
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



