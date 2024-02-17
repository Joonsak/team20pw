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

 $sql = "select * from users";

 $user=mysqli_fetch_object($sql)

 $user->username= $_SESSION['username'];
 $user->password= $_SESSION['password'];
 $user->role=$_SESSION['role'];

 if($_SESSION['role'] !='administrator'){
    header('location: ../index.html');
    exit;
 }
 
?>