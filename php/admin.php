<?php
session_start();
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
$init = parse_ini_file("../asetukset/.ht.asetukset.ini");
try{
    $yhteys=mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);
 }
 catch(Exception $e){
    header("Location:../Pages/Errors/Error.html");
     exit;
 }



if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']===true){
    include './arvostelu2.php';
}else{
    print "<p>You have not logged in so no content for you yet!</p>";
}

?>