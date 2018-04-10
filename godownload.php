<?php
 $fileLoc = $_GET['fileloc'];
 $fileName = $_GET['file'];
 $full = "uploaded/" . $fileLoc;
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=$fileName");
readfile($full);
exit;
?>