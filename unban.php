<?php
session_start();
$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);
header("Content-Type: text/html; charset=windows-1250");

if(isset($_SESSION['isadmin']) != TRUE){
  echo "Tato akce je ur�ena pouze pro p�ihl�en� u�ivatele a administr�tory str�nek.";
  die;
  if($_SESSION['isadmin'] = 0){
  echo "Tato akce je ur�ena pouze pro administr�tory str�nek.";  
  }
}
$id = $_GET['id'];
$sql = "UPDATE poodle.userlogininformation SET isBanned = 0 WHERE id =" . $id . ";";
if($conn->query($sql)){
  echo "U�ivatel byl obnoven.";
} else {
  echo "Stala se chyba.";
}




?>