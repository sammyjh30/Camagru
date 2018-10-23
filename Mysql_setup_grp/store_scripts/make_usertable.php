<?php

$servername = "localhost";
$username = "root";
$password = "Samanthajh30";
$my_db = "camagru_db";

$conn = mysqli_connect($servername, $username, $password);

$usr = "CREATE TABLE `users` (
	`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`username` varchar(100) NOT NULL,
	`email` varchar(100) NOT NULL,
	`password` varchar(100) NOT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=latin1";

$sql = "CREATE DATABASE $my_db";

if (mysqli_query($conn, $sql) === TRUE){
	{
		echo "Database created successfully" . PHP_EOL;
	}
	$conn->close();
	$conn = mysqli_connect($servername, $username, $password, $my_db);
	if ($conn->connect_error) {
		die("Connection failed after creation: " . $conn->connect_error);
	}
	if (mysqli_query($conn, $usr) === TRUE) {
        echo "User table created successfully\n";
    }
}
else {
	echo "Error creating database: " . $conn->error;
}

return ($conn);
?>