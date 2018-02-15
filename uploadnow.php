<?php
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";
echo "<font size='18'>";
echo 'Nahrávání souborù';
echo "</font>";
echo "<p>";
$target_dir = "uploaded/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
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
        $uploadOk = 0;
    }
}
if (file_exists($target_file)) {
    echo "<p>";
    echo "Soubor již existuje.";
    $uploadOk = 0; }
    
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "<p>";
    echo "Váš soubor má pøíliš vysokou velikost (<50MB)";
    $uploadOk = 0;
}
    
if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "docx" && $fileType != "txt" && $fileType != "pdf" && $fileType != "rtf" ) {
    echo "<p>";
    echo "Váš soubor má nepodporovaný formát. Podoporované: PNG,JPG,JPEG,DOCX,TXT,PDF,RTF";
    $uploadOk = 0; }

if ($uploadOk == 0) {
    echo "<p>";
    echo "Omlouváme se, ale váš soubor nemùžeme nahrát";

} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "<p>";
        echo "Váš soubor ". basename( $_FILES["fileToUpload"]["name"]). " byl úspìšnì nahrán na server. Dìkujeme!";
    } else {
        echo "<p>";
        echo "Omlouváme se, ale nastala chyba pøi nahrávání vašeho souboru.";
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