<?php
session_start();

$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("P�ipojen� k MYSQL datab�zi selhalo, chyba: " . $conn->connect_error);
}



header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";

if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>P�ihl�en� u�ivatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav ��tu: ". $row['accountBalance'] . " PoodleCoin�.</div>" ;	
} else { echo "<div class='status'> U�ivatel nep�ihl�en. </div>" ;	}  
?>
<head>
<script src='https://www.google.com/recaptcha/api.js'> </script>
<title>Poodle: Registrace</title>
<div class="menu">
  <a href="index.php">STAHOV�N�</a>
  <a href="upload.php">NAHR�V�N�</a>
  <a href="login.php">P�IHL��EN�</a>
  <a class="active" href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHAT��</a>
  <a href="burza.php">BURZA</a>
  <?php
  if (isset($_SESSION['username'])){
  echo "<a class='logout' href='logout.php'>ODHL�SIT SE</a>" ;
  } 
  if (isset($_SESSION['username'])){
    if($_SESSION['isadmin'] != 0){
      echo "<a href='admin.php'>ADMIN</a>" ;
      }
  }
  ?>
</div>
 <p>
REGISTRACE
 <p>
<form action="" method="post"/>
Va�e jm�no a p��jmen�:
<input type="text" name="name"/>
 <p>
Va�e emailov� adresa:
<input type="text" name="mail"/>
 <p>
-Zadejte sv�j opravdov� e-mail, jak�koliv ot�zky t�kaj�c� se va�eho ��tu, budou odes�l�ny na v�mi zadan� e-mail!
 <p>
Va�e p�ihla�ovac� jm�no
<input type="text" name="nick"/>
 <p>
Va�e heslo:
<input type="password" name="pass"/>
 <p>
Proka�te, �e jste �lov�k:
<div class="g-recaptcha" data-sitekey="6LfH1EkUAAAAAAzJSozvSTJ9lKLW7359kJh36fXo"></div>
<input type="submit" name="submit" value="Potvrdit"/>
</form>
</head>
<style>
/* Add a black background color to the top navigation */

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

.menu a.logout {
    float: right;
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


if (isset($_POST['submit'])) {
  /* GOOGLE RECAPTCHA */
  $secretKey = '6LfH1EkUAAAAACigDzk4Y_3AQdv6DSS7CW8DNIYb';
  $name = $_POST['name'];
  $mail = $_POST['mail'];
  $nick = $_POST['nick'];
  $pass = $_POST['pass']; 
  $responseKey = $_POST['g-recaptcha-response'];
  $ipKey = $_SERVER['REMOTE_ADDR'];
  $send_url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$ipKey";
  

  $response = file_get_contents($send_url);
  $response = json_decode($response);
  
  
  
  if($response->success) {
   

      $makeAccountOK = 0;
      /** CHECK JMENA = POUZE PISMENA, MAX. DELKA 39 **/
      if(!(preg_match("/[a-zA-Z'-]/",$name)) or (strlen($name)) > 40){
          $makeAccountOK = 1;
          echo "�patn� zadan� jm�no a p��jmen�, zadan� jm�no nesm� m�t v�ce jak 40 znak� a zad�vat m��ete pouze p�smena.  <p>";
          }
      /** CHECK MAILU POMOCI FUNKCE, MAX. DELKA 49**/
      if(!(filter_var($mail, FILTER_VALIDATE_EMAIL)) or (strlen($mail) > 50)){
          $makeAccountOK = 2;
          echo "�patn� zadan� email, zadan� email nesm� m�t v�ce jak 50 znak� a zad�vejte ho jen ve form� nazev@mail.koncovka  <p>";
          }

      /** CHECK NICKU, ctype_alnum KONTROLUJE POUZE ALFANUMERICKE, strlen trim == strlen NAM ZJISTI JESTLI JE STEJNA DELKA I PO SMAZANI MEZER, TIM PADEM ZADNE MEZERY, MAX. DELKA 24 **/    
      if(!(ctype_alnum($nick)) or (strlen(preg_replace('/\s+/', '', $nick)) !== strlen($nick)) or strlen($nick) > 25){
          $makeAccountOK = 3;
          echo "�patn� zadan� u�ivatelsk� jm�no, zadan� u�. jm�no nesm� m�t v�ce jak 25 znak� a nesm�te zad�vat mezery nebo speci�ln� znaky (mimo ��slice).  <p>";
          }

      /** CHECK HESLA, strlen trim ZNOVA KONTROLUJE JESTLI OBSAHUJE MEZERY, MIN DELKA 8 a MAXIMALNI 24 **/

      if(strlen($pass) < 7 or strlen($pass) > 25 or (strlen(preg_replace('/\s+/', '', $pass)) !== strlen($pass))){
          echo "�patn� zadan� heslo, zadan� heslo mus� m�t v�ce jak 7 znak�, nesm� obsahovat mezery a nesm� b�t del�� jak 25 znak�. <p>";
          $makeAccountOK = 4;
          }
      
      $checkUser = mysqli_num_rows($conn->query("SELECT username FROM poodle.userlogininformation WHERE username = '" . htmlspecialchars($nick) . "';"));
      if($checkUser > 0){
          echo "U�ivatelsk� jm�no je ji� obsazeno. <p>";
          $makeAccountOK = 5;
      } 
      
      $checkMail = mysqli_num_rows($conn->query("SELECT email FROM poodle.userlogininformation WHERE email = '" . htmlspecialchars($mail) . "';"));
      if($checkMail > 0){
          echo "V�mi zadan� email je ji� zaregistrov�n. <p>";
          $makeAccountOK = 6;
      }
          
 
      if($makeAccountOK == 0){
      /** Zahashov�n� funkce**/
        /** Do hashe p�id�m salt, pomoc� p�id�n� �et�zce mailu **/
        $resultHash = md5($pass . $mail);      
        $sql = "INSERT INTO poodle . userlogininformation (username, passwordHash, firstLastName, email, accountBalance) VALUES ('" . htmlspecialchars($nick) . "' ,'" . $resultHash . "','" . htmlspecialchars($name, ENT_QUOTES,'ISO-8859-1') . "','" . htmlspecialchars($mail) ."', 0);"  ;
        if ($conn->query($sql) === TRUE) {
          echo "Registrace �sp�n�. V�tejte na Poodle!";
        } else {
          echo "Chyba: " . $sql . "<br>" . $conn->error;
        }
        
      
      
      }    
  }
  
  

   
  else {
  
    echo("Potvr�te �e nejste robot pomoc� reCAPTCHA.") ;
    die;
  }
  
 $conn->close();  
 }

 
?>

