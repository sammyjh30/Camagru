<?php 
// DB credentials.
$servername = "localhost";
$username = "root";
$password = "Samanthajh30";
$my_db = "camagru_db";

// Establish database connection.
try {
	$dbh = new PDO("mysql:host=$servername;dbname=$my_db", $username, $password);
	// $dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
}
catch (PDOException $e) {
	exit("Error: " . $e->getMessage());
}

// https://phpgurukul.com/sign-up-and-login-operation-using-pdo/
?>