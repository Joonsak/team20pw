<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$init=parse_ini_file("../asetukset/.ht.asetukset.ini");
try{
    $yhteys=mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);
 }
 catch(Exception $e){
     print "Yhteysvirhe";
     exit;
 }
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "select * from users where username='$username' and password='$password'";
    $result = mysqli_query($yhteys, $sql);

    if($result->num_rows==1){
        $_SESSION['logged_in']=true;
        $_SESSION['username']=$username;
        $_SESSION['password']=$password;
        $_SESSION['role']='administrator';

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
        if ($rivi->stars === "star1") {    echo "<p id='star1'> &#9733;</p>";}
        else if ($rivi->stars === "star2") {echo "<p id='star2'> &#9733;&#9733;</p>";}
        else if ($rivi->stars === "star3") {echo "<p id='star3'> &#9733;&#9733;&#9733;</p>";}
        else if ($rivi->stars === "star4") {echo "<p id='star4'> &#9733;&#9733;&#9733;&#9733;</p>";}
        else if ($rivi->stars === "star5") {echo "<p id='star5'> &#9733;&#9733;&#9733;&#9733;&#9733;</p>";}
        
        echo "<p class='arvostelu'>$rivi->arvostelu</p>";
        echo "<a href='../php/poista.php?poistettava=$rivi->id'><button type='button'>Poista</button></a></p>";
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
    } else {
    }
}
 if($_SESSION['role'] !='administrator'){
    exit;
 }

?>


