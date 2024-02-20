
<?php
// Checks if the form was submitted 
$json=isset($_POST["arvostelut"]) ? $_POST["arvostelut"] : "";
//if not filled gives and error
if (!($arvostelut=tarkistaJson($json))){
    print "Täytä kaikki kentät";
    exit;
}
//connects to the database
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$init=parse_ini_file("../asetukset/.ht.asetukset.ini");
try{
    $yhteys=mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);
 }
 catch(Exception $e){
    header("Location:../Pages/Errors/Error.html");
    exit;
 }

// avaa jsonin ja muuttaa sen
 $arvostelut = json_decode($json);

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
//joihin laitetaan muuttujien arvoja
if ($arvostelut === null) {
    // JSON decoding failed
    // Handle the error, e.g., by printing an error message or logging
    die("Error, try again later");
}
// makes an sql statemnt that inserts data into table
$sql = "INSERT INTO arvostelut (nimimerkki, arvostelu, stars) VALUES (?, ?, ?)";
// protects against attacks
$stmt = mysqli_prepare($yhteys, $sql);
//binds review data into statements
mysqli_stmt_bind_param($stmt, 'sss', $arvostelut->nimimerkki, $arvostelut->arvostelu, $arvostelut->stars);
//executes the statement
mysqli_stmt_execute($stmt);
//gets all the reviews from arvostelut table
$tulos=mysqli_query($yhteys, "select * from arvostelut");


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
    echo "</div>";
    echo "</div>";
    
    $i++;
    
    if ($i % 3 === 0) {
        // closes the row after 3 reviews 
        echo "</div>";
    }
}

if ($i % 3 !== 0) {
    //closes the row if the amount of reviews is not a multiple of 3
    echo "</div>";
}

print "</div>"; // Closes the review box part

//mysqli_close($yhteys);


?>


<?php
//function that checks that all fields have been filled
function tarkistaJson($json){
    if (empty($json)){
        return false;
    }
    $arvostelut=json_decode($json, false);
    if (empty($arvostelut->nimimerkki) || empty($arvostelut->arvostelu)  || empty($arvostelut->stars)){
        return false;
    }
    return $arvostelut;
}
?>
