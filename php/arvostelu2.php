<?php 
//connects to the database
$init = parse_ini_file("../asetukset/.ht.asetukset.ini");
$yhteys = mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);

// Check if the connection was successful
if (!$yhteys) {
    die("Connection failed: " . mysqli_connect_error());
}
//gets all the reviews from arvostelut table
$tulos = mysqli_query($yhteys, "SELECT * FROM arvostelut");

if ($tulos) { // Checks if query was successful
    print "<div class='container'>"; // Starts the container where the reviews are

    $i = 0; // Counts the amount of reviews
    
    while ($rivi=mysqli_fetch_object($tulos)){
        if ($i % 3 === 0) {
              // Starts a new row after 3 reviews
            echo "<div class='row'>";
        }
        
        // content of the review box
        echo "<div class='col-md-4'>";
        echo "<div class='review-container'>";
        echo "<h2>$rivi->nimimerkki</h2>";
        if ($rivi->stars === "star1") {    echo "<p id='star1'> &#9733;</p>";}
        else if ($rivi->stars === "star2") {echo "<p id='star2'> &#9733;&#9733;</p>";}
        else if ($rivi->stars === "star3") {echo "<p id='star3'> &#9733;&#9733;&#9733;</p>";}
        else if ($rivi->stars === "star4") {echo "<p id='star4'> &#9733;&#9733;&#9733;&#9733;</p>";}
        else if ($rivi->stars === "star5") {echo "<p id='star5'> &#9733;&#9733;&#9733;&#9733;&#9733;</p>";}
        
        echo "<p class='arvostelu'>$rivi->arvostelu</p>";
        //if the person has logged in show delete button
        if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']===true) {echo "<a href='../php/poista.php?poistettava=$rivi->id'><button type='button'>Delete</button></a></p>";}
        echo "</div>";
        echo "</div>";
        
        $i++;
        
        if ($i % 3 === 0) {
            // close the row after 3 reviews
            echo "</div>";
        }
    }
} else {
    echo "Error executing query: " . mysqli_error($yhteys);
}
//closes connection
mysqli_close($yhteys);
?>