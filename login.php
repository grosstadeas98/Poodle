<?php
header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";
?>
<head>
<div class="menu">
  <a href="index.php">STAHOV�N�</a>
  <a href="upload.php">NAHR�V�N�</a>
  <a class="active" href="login.php">P�IHL��EN�</a>
  <a href="join.php">REGISTRACE</a>
</div>

 <p>
P�IHL��EN�
 <p>
<form id="login" action="login.php" method="post">
<input type="hidden" name="submitted" id="submitted" value="1">
Va�e p�ihla�ovac� jm�no:
<input type="text" name="name" id="name" maxlenght ="50">
 <p>
Va�e heslo:
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
</head>
