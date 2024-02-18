<?php
// Start a new session or resume the existing one
session_start();

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);

// connects to the database
$init = parse_ini_file("../asetukset/.ht.asetukset.ini");

try {
    $yhteys = mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);
} catch(Exception $e) {
    print "Yhteysvirhe";
    exit;
}

// gets the id of the to be deleted review
$poistettava = isset($_GET["poistettava"]) ? $_GET["poistettava"] : "";

// if its not empty it deletes the spefic id
if (!empty($poistettava)) {
    $sql = "DELETE FROM arvostelut WHERE id=?";

    // prepares the sql execution
    $stmt = mysqli_prepare($yhteys, $sql);

    // binds the id 
    mysqli_stmt_bind_param($stmt, 'i', $poistettava);

    // executes the sql statement
    mysqli_stmt_execute($stmt);
}

// closes the database connection
mysqli_close($yhteys);

// Takes you back to the admin page
header("Location:../Pages/Admin.html");
exit;
?>
