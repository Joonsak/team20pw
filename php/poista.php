<?php
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$init=parse_ini_file("../asetukset/.ht.asetukset.ini");
try{
    $yhteys=mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);
 }
 catch(Exception $e){
     print "Yhteysvirhe";
     exit;
 }

$poistettava=isset($_GET["poistettava"]) ? $_GET["poistettava"] : "";

//Jos tieto on annettu, poistetaan kala tietokannasta
if (!empty($poistettava)){
    $sql="delete from arvostelut where id=?";
    $stmt=mysqli_prepare($yhteys, $sql);
    //Sijoitetaan muuttuja sql-lauseeseen
    mysqli_stmt_bind_param($stmt, 'i', $poistettava);
    //Suoritetaan sql-lause
    mysqli_stmt_execute($stmt);
}
//Suljetaan tietokantayhteys
mysqli_close($yhteys);
//ja ohjataan pyyntö takaisin listaukseen
header("Location:../Pages/Reviews.html");
exit;
?>