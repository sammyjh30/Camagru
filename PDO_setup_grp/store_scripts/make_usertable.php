<?php

$servername = "localhost";
$username = "root";
$password = "Samanthajh30";
$my_db = "camagru_db";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // sql to create table
    
	$sql = "CREATE DATABASE $my_db";
    // use exec() because no results are returned
    $conn->exec($sql);
	echo "Database created successfully" . PHP_EOL;
	$conn = null;
	$conn = new PDO("mysql:host=$servername;dbname=$my_db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//create table
	$usr = "CREATE TABLE `users` (
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`username` varchar(100) NOT NULL,
		`name` varchar(100) NOT NULL,
		`surname` varchar(100) NOT NULL,
		`email` varchar(100) NOT NULL,
		`password` varchar(100) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1";
	
	$conn->exec($usr);
    echo "Table users created successfully" . PHP_EOL;
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage() . PHP_EOL;
}
$conn = null;

// return ($conn);
?>