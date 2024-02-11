<?php 
$init = parse_ini_file("../asetukset/.ht.asetukset.ini");
$yhteys = mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);

// Check if the connection was successful
if (!$yhteys) {
    die("Connection failed: " . mysqli_connect_error());
}

$tulos = mysqli_query($yhteys, "SELECT * FROM arvostelut");

if ($tulos) { // Check if query was successful
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
} else {
    echo "Error executing query: " . mysqli_error($yhteys);
}

mysqli_close($yhteys);
?>