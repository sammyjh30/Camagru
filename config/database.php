<?php

// initializing variables
$servername = "localhost";
$username = "root";
$password = "123456";
$my_db = "camagru_db";

//connecting to Database
$pdoOptions =  [PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES   => false,
				PDO::ATTR_EMULATE_PREPARES => false];
$pdo = new PDO("mysql:host=$servername;dbname=$my_db", $username, $password, $pdoOptions);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if (!$pdo) {
	die("Connection failed: " . mysqli_connect_error());
}
return ($pdo);
?>