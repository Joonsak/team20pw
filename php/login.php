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
if($_SERVER["REQUEST_METHOD"]=="post"){
    $username = $_POST["user"];
    $password = $_POST["pass"];

    $sql = "select * from users where username='$username' and password='$password'";
    $result = query($sql);
    if($result->num_rows==1){
        $_SESSION['logged_in']=true;
        $_SESSION['username']=$username;
        $_SESSION['password']=$password;
        $_SESSION['role']='administrator';
        header('Location:../Pages/Admin.html');
        exit;
    } else {
        header('Location:../index.html');
        exit;
    }
}
 if($_SESSION['role'] !='administrator'){
    header('location: ../index.html');
    exit;
 }

?>