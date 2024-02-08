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
tähän alle tulee se print div osuus
