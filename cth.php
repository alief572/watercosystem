<?php
$servername = "localhost";
$database = "mysql";
$username = "admin_mysql";
$password = "Sentral203!";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
mysqli_close($conn);
?>
