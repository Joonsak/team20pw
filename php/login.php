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
        exit;
    } else {
        exit;
    }
}
 if($_SESSION['role'] !='administrator'){
    exit;
 }

?>