<?php
session_start();

$servername = "localhost";
$username = "root";
$conn = new mysqli($servername, $username);

if ($conn->connect_error) {
  die("Pøipojení k MYSQL databázi selhalo, chyba: " . $conn->connect_error);
}



header("Content-Type: text/html; charset=windows-1250");
echo "<a href='index.php'><img src='./poodle_logo2.bmp' height ='180' width '360'   /></a><br>\n";

if (isset($_SESSION['username'])) {
  $sql = "SELECT accountBalance FROM poodle.userlogininformation WHERE username = '" . $_SESSION['username'] . "';";
  $result = $conn->query($sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
  echo "<div class='status'>Pøihlášený uživatel: <font color='purple'>" . $_SESSION["username"] . "</font> ,stav úètu: ". $row['accountBalance'] . " PoodleCoinù.</div>" ;	
} else { echo "<div class='status'> Uživatel nepøihlášen. </div>" ;	}  
?>
<head>
<script src='https://www.google.com/recaptcha/api.js'> </script>
<title>Poodle: Registrace</title>
<div class="menu">
  <a href="index.php">STAHOVÁNÍ</a>
  <a href="upload.php">NAHRÁVÁNÍ</a>
  <a href="login.php">PØIHLÁŠENÍ</a>
  <a class="active" href="join.php">REGISTRACE</a>
  <a href="toplist.php">NEJBOHATŠÍ</a>
  <a href="burza.php">BURZA</a>
  <?php
  if (isset($_SESSION['username'])){
  echo "<a class='logout' href='logout.php'>ODHLÁSIT SE</a>" ;
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
Vaše jméno a pøíjmení:
<input type="text" name="name"/>
 <p>
Vaše emailová adresa:
<input type="text" name="mail"/>
 <p>
-Zadejte svùj opravdový e-mail, jakékoliv otázky týkající se vašeho úètu, budou odesílány na vámi zadaný e-mail!
 <p>
Vaše pøihlašovací jméno
<input type="text" name="nick"/>
 <p>
Vaše heslo:
<input type="password" name="pass"/>
 <p>
Prokažte, že jste èlovìk:
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
          echo "Špatnì zadané jméno a pøíjmení, zadané jméno nesmí mít více jak 40 znakù a zadávat mùžete pouze písmena.  <p>";
          }
      /** CHECK MAILU POMOCI FUNKCE, MAX. DELKA 49**/
      if(!(filter_var($mail, FILTER_VALIDATE_EMAIL)) or (strlen($mail) > 50)){
          $makeAccountOK = 2;
          echo "Špatnì zadaný email, zadaný email nesmí mít více jak 50 znakù a zadávejte ho jen ve formì nazev@mail.koncovka  <p>";
          }

      /** CHECK NICKU, ctype_alnum KONTROLUJE POUZE ALFANUMERICKE, strlen trim == strlen NAM ZJISTI JESTLI JE STEJNA DELKA I PO SMAZANI MEZER, TIM PADEM ZADNE MEZERY, MAX. DELKA 24 **/    
      if(!(ctype_alnum($nick)) or (strlen(preg_replace('/\s+/', '', $nick)) !== strlen($nick)) or strlen($nick) > 25){
          $makeAccountOK = 3;
          echo "Špatnì zadané uživatelské jméno, zadané už. jméno nesmí mít více jak 25 znakù a nesmíte zadávat mezery nebo speciální znaky (mimo èíslice).  <p>";
          }

      /** CHECK HESLA, strlen trim ZNOVA KONTROLUJE JESTLI OBSAHUJE MEZERY, MIN DELKA 8 a MAXIMALNI 24 **/

      if(strlen($pass) < 7 or strlen($pass) > 25 or (strlen(preg_replace('/\s+/', '', $pass)) !== strlen($pass))){
          echo "Špatnì zadané heslo, zadané heslo musí mít více jak 7 znakù, nesmí obsahovat mezery a nesmí být delší jak 25 znakù. <p>";
          $makeAccountOK = 4;
          }
      
      $checkUser = mysqli_num_rows($conn->query("SELECT username FROM poodle.userlogininformation WHERE username = '" . htmlspecialchars($nick) . "';"));
      if($checkUser > 0){
          echo "Uživatelské jméno je již obsazeno. <p>";
          $makeAccountOK = 5;
      } 
      
      $checkMail = mysqli_num_rows($conn->query("SELECT email FROM poodle.userlogininformation WHERE email = '" . htmlspecialchars($mail) . "';"));
      if($checkMail > 0){
          echo "Vámi zadaný email je již zaregistrován. <p>";
          $makeAccountOK = 6;
      }
          
 
      if($makeAccountOK == 0){
      /** Zahashování funkce**/
        /** Do hashe pøidám salt, pomocí pøidání øetìzce mailu **/
        $resultHash = md5($pass . $mail);      
        $sql = "INSERT INTO poodle . userlogininformation (username, passwordHash, firstLastName, email, accountBalance) VALUES ('" . htmlspecialchars($nick) . "' ,'" . $resultHash . "','" . htmlspecialchars($name, ENT_QUOTES,'ISO-8859-1') . "','" . htmlspecialchars($mail) ."', 0);"  ;
        if ($conn->query($sql) === TRUE) {
          echo "Registrace úspìšná. Vítejte na Poodle!";
        } else {
          echo "Chyba: " . $sql . "<br>" . $conn->error;
        }
        
      
      
      }    
  }
  
  

   
  else {
  
    echo("Potvrïte že nejste robot pomocí reCAPTCHA.") ;
    die;
  }
  
 $conn->close();  
 }

 
?>

