
<?php
header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";
?>
<head>
<div class="menu">
  <a href="index.php">STAHOVÁNÍ</a>
  <a class="active" href="upload.php">NAHRÁVÁNÍ</a>
  <a href="login.php">PØIHLÁŠENÍ</a>
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


?>

<!DOCTYPE html>
<html>
<body>

<form action="uploadnow.php" method="post" enctype="multipart/form-data">
    Vyber do které kategorie soubor pøidat:
    <p>
    <select name="cathegory">
      <option value="cej/">Èeský jazyk</option>
      <option value="anj/">Anglický jazyk</option>
      <option value="mat/">Matematika</option>
      <option value="nej/">Nìmecký jazyk</option>
      <option value="eko/">Ekonomika</option>
      <option value="pos/">Poèítaèové sítì</option>
      <option value="tvy/">Technické vybavení</option>
      <option value="pad/">Programování a databáze</option>
      <option value="grw/">Grafika a webdesign</option>
      <option value="aut/">Automatizace</option>
      <option value="cisco/">CISCO</option>
      <option value="prc/">Praktické cvièení</option>
      <option value="ops/">Operaèní systémy</option>
      <option value="asw/">Aplikaèní software</option>
      <option value="other/">Ostatní/Neuvedeno</option>
    </select>
    <p>
    Vyber soubor:
    <p>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Nahrát" name="submit">
  
    
</form>

</body>
</html>