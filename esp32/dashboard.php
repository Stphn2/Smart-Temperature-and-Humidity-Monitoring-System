<?php
// para mag connect sa database
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "esp_data"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// NAga kwa latest data for display by time stamp
$sql_latest = "SELECT temperature, humidity FROM logs ORDER BY log_time DESC LIMIT 1";
$result_latest = $conn->query($sql_latest);

if ($result_latest->num_rows > 0) {
    $row_latest = $result_latest->fetch_assoc();
    $latestTemp = $row_latest['temperature'];
    $latestHum = $row_latest['humidity'];
} else {
    $latestTemp = 0;
    $latestHum = 0;
}

// Naga kwa all logs para sa table
$sql_logs = "SELECT * FROM logs ORDER BY log_time DESC";
$result_logs = $conn->query($sql_logs);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='refresh' content='4'/>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' integrity='sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr' crossorigin='anonymous'>
    <title>Smart Temperature and Humidity Monitoring System</title>
    <style>
      html { font-family: Arial; display: inline-block; margin: 0px auto; text-align: center;}
      h2 { font-size: 3.0rem; }
      p { font-size: 3.0rem; }
      .units { font-size: 1.2rem; }
      .dht-labels{ font-size: 1.5rem; vertical-align:middle; padding-bottom: 15px;}
      table { margin: 20px auto; border-collapse: collapse; width: 90%; max-width: 700px;}
      th, td { border: 1px solid #ddd; padding: 8px; font-size: 1.2rem;}
      th { background-color: #f2f2f2; }
      tr:nth-child(even) {background-color: #f9f9f9;}
    </style>
  </head>
  <body>
    <h2>Smart Temperature and Humidity Monitoring System</h2>
    <p>
      <i class='fas fa-thermometer-half' style='color:#ca3517;'></i>
      <span class='dht-labels'>Temperature</span>
      <span><?php echo number_format($latestTemp, 2); ?></span>
      <sup class='units'>&deg;C</sup>
    </p>
    <p>
      <i class='fas fa-tint' style='color:#00add6;'></i>
      <span class='dht-labels'>Humidity</span>
      <span><?php echo number_format($latestHum, 2); ?></span>
      <sup class='units'>&percnt;</sup>
    </p>

    <h3>Logged Data</h3>
    <table>
      <tr>
        <th>ID</th>
        <th>Temperature (&deg;C)</th>
        <th>Humidity (%)</th>
        <th>Timestamp</th>
      </tr>
      <?php
      if ($result_logs->num_rows > 0) {
          while($row = $result_logs->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row["id"] . "</td>";
              echo "<td>" . number_format($row["temperature"], 2) . "</td>";
              echo "<td>" . number_format($row["humidity"], 2) . "</td>";
              echo "<td>" . $row["log_time"] . "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No data logged yet.</td></tr>";
      }
      $conn->close();
      ?>
    </table>
  </body>
</html>
