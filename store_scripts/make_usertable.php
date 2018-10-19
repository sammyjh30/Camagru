<?php
require "connect_database.php";

$sql = "CREATE TABLE 'users' (
'id' int(11) NOT NULL auto_increment,
'username' varchar(100) NOT NULL,
'email' varchar(100) NOT NULL,
'password' varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if (mysqli_query($conn, $sql))
	echo "User Table created successfully.";
else
	echo "Error creating table " . mysqli_error($conn);

	mysqli_close($conn);
?>