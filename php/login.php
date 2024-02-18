<?php
// Start a new session or resume the existing one
session_start();

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// connects to the database
$init = parse_ini_file("../asetukset/.ht.asetukset.ini");

try {
    $yhteys = mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);
} catch(Exception $e) {
    print "Yhteysvirhe";
    exit;
}

// checks if method is post
if($_SERVER["REQUEST_METHOD"]=="POST") {
    // Get the username and password from post data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Checks if the given username and password match one in the database
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    
    // Executes query
    $result = mysqli_query($yhteys, $sql);

    // If it matches it sets up session variables and shows reviews with delete button
    if($result->num_rows==1){
        // Set session variables
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['role'] = 'administrator';

        // Gets the reviews from database
        $tulos = mysqli_query($yhteys, "SELECT * FROM arvostelut");

        // If the query was successful shows the reviews
        if ($tulos) {
            // Starts the container where the reviews are
            print "<div class='container'>"; 

            // Counts the amount of reviews
            $i = 0; 

            // Loops through all reviews
            while ($rivi=mysqli_fetch_object($tulos)){
                if ($i % 3 === 0) {
                    // Starts a new row after every third review
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
                echo "<a href='../php/poista.php?poistettava=$rivi->id'><button type='button'>Delete</button></a></p>";
                echo "</div>";
                echo "</div>";
        
                $i++;
        
                if ($i % 3 === 0) {
                    // Closes the row after 3 reviews
                    echo "</div>";
                }
            }
        } else {
            // If there was an error executing the query shows the error message
            echo "Error executing query: " . mysqli_error($yhteys);
        }

        // Closes the database connection
        mysqli_close($yhteys);
    } else {
    }
}

// If the user's role is not 'administrator', exits
if($_SESSION['role'] !='administrator'){
    exit;
}
?>
