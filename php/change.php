<?php
// connects to the database
$init = parse_ini_file("../asetukset/.ht.asetukset.ini");

try {
    $yhteys = mysqli_connect($init["databaseserver"], $init["username"], $init["password"], $init["database"]);
} catch(Exception $e) {
    header("Location:../Pages/Errors/Error.html");
    exit;
}
// Define the username whose password you want to hash
$username = 'tester';

// Define the password you want to hash
$password = 'test';

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL query
$query = "UPDATE users SET password = ? WHERE username = ?";

// Create a prepared statement
$stmt = mysqli_prepare($yhteys, $query);

// Bind parameters to the prepared statement
mysqli_stmt_bind_param($stmt, 'ss', $hashedPassword, $username);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Close the statement and the connection
mysqli_stmt_close($stmt);
mysqli_close($yhteys);
?>
