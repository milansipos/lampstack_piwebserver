<?php 
include "session.php";
include "profilemenu.php";
include "navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styling/weather.css">
    <script src="../app/weather.js"></script>
    <title>Weather page</title>
</head>
<body>
    

    <?php

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once "../ignore/config.php";
        
    $api = $OPENWEATHER_API_KEY;
    $lat = 46.84;
    $lon = 16.84;

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if(isset($_POST['lon'])) {
            $lat = $_POST['lat'];
            $lon = $_POST['lon'];
        }
    }

    $url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$api";

    $ch = curl_init(); // Initialize cURL session
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response instead of outputting it
    
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    if (isset($data['main'])) {
        $city = $data['name'] ?? "Unknown City";
        $temp = round($data['main']['temp'] - 273.15, 1);
        $maxtemp = round($data['main']['temp_max'] - 273.15, 1);
        $mintemp = round($data['main']['temp_min'] - 273.15, 1);
        $humidity = $data['main']['humidity'];
        $windspeed = $data['wind']['speed'];
        $maininfo = $data['weather'][0]['main'];
        $description = $data['weather'][0]['description'];
    } else {
        $city = "Invalid Location";
        $temp = $maxtemp = $mintemp = $humidity = $windspeed = 0;
        $maininfo = $description = "No Data Available";
    }

    ?>

    <div class="newbody">

        <div class="searchbox">
            <form method="post" class="searchform">
                <input type="text" placeholder="Longitude" name="lon" class="searchtext" required>
                <input type="text" placeholder="Latitude" name="lat" class="searchtext" required>
                <input type="submit" value="Check" class="submit">
            </form>
        </div>

        <div class="box1" id="box1">
            <?php echo "<div class='degree'>" . $temp . "°C</div>" ?>
            <?php echo "<div class='city'>" . $city . "</div>" ?>

            <img src="../img/sun.png" alt="sunlogo" class="sunpicture" id="img">
        </div>

        <div class="box2" id="box1">
            <?php echo "<div class='maxdegree'><img src='../img/temp.png' class='temppic'> <br>Max<br> Temp <br> " . $maxtemp . "°C</div>" ?>
            <?php echo "<div class='mindegree'><img src='../img/temp.png' class='temppic'> <br>Min<br> Temp <br>" . $mintemp . "°C</div>" ?>

            <?php echo "<div class='wind'><img src='../img/wind.png' class='windpic'> <br>Windspeed <br>" . $windspeed . "km/h</div>" ?>
            <?php echo "<div class='humid'><img src='../img/humid.png' class='humidpic'> <br>Humidity <br>" . $humidity . "%</div>" ?>
        </div>


        <div class="box3">
            <?php echo "<div class='info'>" . $maininfo . "</div>" ?>
            <?php echo "<div class='desc'> This resembles the weather <br> in your city: " . $description . "</div>" ?>

        </div>
    </div>

</body>
</html>