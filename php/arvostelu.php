
<?php

$json=isset($_POST["arvostelut"]) ? $_POST["arvostelut"] : "";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$init=parse_ini_file("../asetukset/.ht.asetukset.ini");
try{
    $yhteys=mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);
 }
 catch(Exception $e){
     print "Yhteysvirhe";
     exit;
 }


 $arvostelut = json_decode($json);

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
//joihin laitetaan muuttujien arvoja
if ($arvostelut === null) {
    // JSON decoding failed
    // Handle the error, e.g., by printing an error message or logging
    die("JSON decoding failed");
}

$sql = "INSERT INTO arvostelut (nimimerkki, arvostelu) VALUES (?, ?)";
$stmt = mysqli_prepare($yhteys, $sql);

mysqli_stmt_bind_param($stmt, 'ss', $arvostelut->nimimerkki, $arvostelut->arvostelu);
mysqli_stmt_execute($stmt);
//Suljetaan tietokantayhteys
$tulos=mysqli_query($yhteys, "select * from arvostelut");


print "<div class=arvostelus>";
while ($rivi=mysqli_fetch_object($tulos)){
print "<div>";
print "<h2>$rivi->nimimerkki</h2>";
print"<p> $rivi->arvostelu</p>";
print"</div>"; 
}
print"</div>"; 


//mysqli_close($yhteys);


?>


<?php
function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $arvostelut=json_decode($json, false);
    if (empty($arvostelut->nimimerkki) || empty($arvostelut->arvostelu)){
        return false;
    }
    return $arvostelut;
}
?>
