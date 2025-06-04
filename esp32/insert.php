<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "esp_data";

// Para sa connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Naga check sang connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$temperature = $_GET['temperature'];
$humidity = $_GET['humidity'];

$sql = "INSERT INTO logs (temperature, humidity) VALUES ('$temperature', '$humidity')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
