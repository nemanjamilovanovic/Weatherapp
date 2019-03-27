<?php
include 'bootstrap.php';

$weatherApi = new WeatherApi(
    $config['dark_sky_api']['baseUrl'],
    $config['dark_sky_api']['key']
);

$cities = $weatherManager->getCitiesWithCoordinates();

foreach ($cities as $id => $city) {
    $data = $weatherApi->fetchWeatherDarkSkyForCity($city['lon'], $city['lat']);
    foreach ($data['hourly']['data'] as $item) {
        $weatherManager->handleWeather($id, $item['temperature'], $item['windSpeed'], $item['precipType'], $item['time']);
    }

    echo 'Updated ' . $city['name'] . '<br/>';
}