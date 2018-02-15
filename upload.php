<?php
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";
echo "<font size='18'>";
echo 'Nahrávání souborù';
echo "</font>";


?>

<!DOCTYPE html>
<html>
<body>

<form action="uploadnow.php" method="post" enctype="multipart/form-data">
    Vyber soubor:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Nahrát" name="submit">
</form>

</body>
</html>