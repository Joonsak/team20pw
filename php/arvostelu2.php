<?php 
$init = parse_ini_file("../asetukset/.ht.asetukset.ini");
$yhteys = mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);

// Check if the connection was successful
if (!$yhteys) {
    die("Connection failed: " . mysqli_connect_error());
}

$tulos = mysqli_query($yhteys, "SELECT * FROM arvostelut");

if ($tulos) { // Check if query was successful
    print "<div class='arvostelus'>";
    while ($rivi = mysqli_fetch_object($tulos)) {
        print "<div>";
        print "<h2>$rivi->nimimerkki</h2>";
        print "<p>$rivi->arvostelu</p>";
        print "</div>"; 
    }
    print "</div>"; 
} else {
    echo "Error executing query: " . mysqli_error($yhteys);
}

mysqli_close($yhteys);
?>