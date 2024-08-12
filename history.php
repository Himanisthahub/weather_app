<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "weather_database";

// Get the city parameter from the query string
$cityParam = $_GET['city'];

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database for past weather data for the specified city
$sql = "SELECT * FROM weather_data WHERE city = '$cityParam' AND DATE(date) < CURDATE() ORDER BY date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Generate HTML for past weather data
    while ($row = $result->fetch_assoc()) {
        $city = $row['city'];
        $temperature = $row['temperature'];
        $humidity = $row['humidity'];
        $pressure = $row['pressure'];
        $wind = $row['wind'];
        $description = $row['description'];
        $date = date('l, F j, Y', strtotime($row['date']));

        echo "<div class='past-weather-box'>
                  <div class='past-weather-content'>
                      <h2>Past Weather Data for $city on $date</h2>
                      <p>Temperature: $temperature °C</p>
                      <p>Humidity: $humidity%</p>
                      <p>Pressure: $pressure Pa</p>
                      <p>Wind Speed: $wind m/s</p>
                      <p>Description: $description</p>
                  </div>
              </div>";
    }
} else {
    echo "No past weather data available for $cityParam";
}

// Close the database connection
$conn->close();
?>