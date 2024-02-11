
<?php

$json=isset($_POST["arvostelut"]) ? $_POST["arvostelut"] : "";

if (!($arvostelut=tarkistaJson($json))){
    print "Täytä kaikki kentät";
    exit;
}

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
$tulos=mysqli_query($yhteys, "select * from arvostelut");


print "<div class='container'>"; // Start with a container to hold the rows

$i = 0; // Counter for tracking the number of reviews

while ($rivi=mysqli_fetch_object($tulos)){
    if ($i % 3 === 0) {
        // Start a new row after every third review
        echo "<div class='row'>";
    }
    
    // Output each review inside a column div
    echo "<div class='col-md-4'>";
    echo "<div class='review-container'>";
    echo "<h2>$rivi->nimimerkki</h2>";
    echo "<p class='arvostelu'>$rivi->arvostelu</p> <a href='../php/poista.php?poistettava=$rivi->id'>Poista</a></p>";
    echo "</div>";
    echo "</div>";
    
    $i++;
    
    if ($i % 3 === 0) {
        // Close the row after every third review
        echo "</div>";
    }
}

if ($i % 3 !== 0) {
    // Close the row if the number of reviews is not a multiple of three
    echo "</div>";
}

print "</div>"; // Close the container div

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
