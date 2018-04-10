<?php
session_start();
$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);
header("Content-Type: text/html; charset=windows-1250");

if(isset($_SESSION['isadmin']) != TRUE){
  echo "Tato akce je urèena pouze pro pøihlášené uživatele a administrátory stránek.";
  die;
  if($_SESSION['isadmin'] = 0){
  echo "Tato akce je urèena pouze pro administrátory stránek.";  
  }
}
$id = $_GET['id'];
$sql = "UPDATE poodle.userlogininformation SET isBanned = 0 WHERE id =" . $id . ";";
if($conn->query($sql)){
  echo "Uživatel byl obnoven.";
} else {
  echo "Stala se chyba.";
}




?>