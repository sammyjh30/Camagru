<?php

$servername = "localhost";
$username = "root";
$password = "Samanthajh30";
$my_db = "shopdb";

$conn = mysqli_connect($servername, $username, $password, $my_db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
return ($conn);

?>