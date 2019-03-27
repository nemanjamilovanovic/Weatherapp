<?php
    include 'bootstrap.php';

    if (empty($_SESSION['user'])) {
        die('Access Denied');
    }

    $cities = $weatherManager->getCitiesWithCoordinates();
    $weatherData = [];


    if (!empty($_GET['city'])) {
        $geoLocation = $cities[$_GET['city']];

        $weatherData = $weatherManager->getWeatherForCityAndTimeInPast($_GET['city']);
    }
?>

<html>
<head>
    <title>Weather List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
    <h1>Weather in Slovenia</h1>
      <ul class="main-nav">
        <li>
            <a href="weather.view.php">Current weather</a>
        </li>
        <li>
            <a href="weather.history.php">Weather history</a>
        </li>
    </ul>
</header>
<form method="get">
    <select name="city">
        <?php foreach($cities as $key=>$value): ?>
            <option <?php echo $key == $_GET['city'] ? 'selected="selected"' : ''?> value="<?php echo $key; ?>"><?php echo $value['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <input class="btn btn-primary btn-sm" type="submit" value="Get Weather"/>
</form>
<?php if (!empty($weatherData)) {?>
  <h2>Weather in <?php echo $cities[$_GET['city']]['name'];?></h2>
<div class="tbl1">
    <table class="table table-striped">
    <tr>
      <th>Day and time</th>
      <th>Temperature</th>
      <th>Wind speed</th>
      <th>Precipitation</th>
    </tr>
    <tr>
        <?php foreach($weatherData as $data): ?>
      <td><?php echo date('l @ H:i', $data['weather_time']);?></td>
      <td><?php echo round($data['temperature']);?><b> &#8451;</b></td>
      <td><?php echo $data['windspeed'];?><b> m/s</b></td>
      <td><?php echo !empty($data['preciptype']) ? $data['preciptype'] : 'None';?></td>
    </tr>

    <?php endforeach; ?>

<!--    <pre>-->
<!--    --><?php
//    print_r($weatherData);
//    ?>
    </pre>
<?php } ?>
</table>
</div>

</body>
</html>
