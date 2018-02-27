<?php
if(file_exists("./uploaded/") !== True) {
  mkdir("./uploaded/", 0700, True);
  mkdir("./uploaded/cej", 0700, True);
  mkdir("./uploaded/anj", 0700, True);
  mkdir("./uploaded/mat", 0700, True);
  mkdir("./uploaded/nej", 0700, True);
  mkdir("./uploaded/eko", 0700, True);
  mkdir("./uploaded/pos", 0700, True);
  mkdir("./uploaded/tvy", 0700, True);
  mkdir("./uploaded/pad", 0700, True);
  mkdir("./uploaded/grw", 0700, True);
  mkdir("./uploaded/aut", 0700, True);
  mkdir("./uploaded/cisco", 0700, True);
  mkdir("./uploaded/prc", 0700, True);
  mkdir("./uploaded/ops", 0700, True);
  mkdir("./uploaded/asw", 0700, True);
  mkdir("./uploaded/other", 0700, True);
  echo("Složky úspìšnì vytvoøeny.");
} 
else {
  echo("Složky již existují.");
}

?>