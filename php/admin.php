<?php
//Session starts for the "account" to be logged in and having his stuff printed so he can delete reviews if it is for example suspected
//to be spam or other kind of hurtful in a way.
session_start();
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
//here we have the stuff for getting connection to the database. 
$init = parse_ini_file("../asetukset/.ht.asetukset.ini");
try{
    $yhteys=mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);
 }
 catch(Exception $e){
     print "Yhteysvirhe";
     exit;
 }


//this checks if you have logged in and it has been to the session. Then it gives whatever is in the if. If you have not logged in it will give you something else. 
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']===true){
    //here we include arvostelu2.php so we can have the reviews printed with delete function so we can delete reviews
    include './arvostelu2.php';
}else{
    //here we tell in the admin page that user has not logged in and has no access to delete reviews 
    //or any other function that we may or may not add in later date.
    print "<p>You have not logged in so no content for you yet!</p>";
}

?>