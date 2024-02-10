<?php 
$init=parse_ini_file("../asetus/.ht.asetukset.ini");
try{
   $yhteys=mysqli_connect($init["palvelin"], $init["tunnus"], $init["pass"], $init["tk"]);
}
catch(Exception $e){
    print "Yhteysvirhe";
    exit;
}
$tulos=mysqli_query($yhteys, "select * from arvostelut");
print "<div class=arvostelus>";
while ($rivi=mysqli_fetch_object($tulos)){
print "<div>";
print "<h2>$rivi->nimimerkki</h2>";
print"<p> $rivi->arvostelu</p>";
print"</div>"; 
}
print"</div>"; 
