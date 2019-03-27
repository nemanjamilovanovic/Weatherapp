<?php

class WeatherManager
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * WeatherManager constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param $cityId
     * @param $temperature
     * @param $windSpeed
     * @param $precipType
     */
    public function handleWeather($cityId, $temperature, $windSpeed, $precipType, $weatherTime){
        $params = [
            'city_id' => $cityId,
            'temperature' => $temperature,
            'windspeed' => $windSpeed,
            'preciptype' => $precipType,
            'weather_time' => $weatherTime,
        ];

        $query = '
            INSERT INTO weather (
                city_id,
				crdate,                
                temperature,
                windspeed, 
                preciptype,
                weather_time
            ) 
            
            VALUES 
            (
                :city_id,
                NOW(),
                :temperature, 
                :windspeed,
                :preciptype,
                :weather_time  
            )
        ';

        $statement = $this->pdo->prepare($query);
        $statement->execute($params);
    }

    public function getWeatherForCityAndTime($cityId) {
        $query = '
            SELECT DISTINCT
              temperature, 
              weather_time, 
              windspeed, 
              preciptype,
              weather_time
            FROM 
              weather 
            WHERE 
              weather_time BETWEEN UNIX_TIMESTAMP(NOW()) AND UNIX_TIMESTAMP(DATE_ADD(NOW(), INTERVAL 12 HOUR ))
              AND
              city_id = :city_id
            ORDER BY id ASC LIMIT 12
              ';

        $statement = $this->pdo->prepare($query);
        $statement->execute(['city_id' => $cityId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWeatherForCityAndTimeInPast($cityId) {
        $query = '
            SELECT DISTINCT
              temperature, 
              weather_time, 
              windspeed, 
              preciptype
            FROM 
              weather 
            WHERE 
              weather_time > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 12 HOUR) )
              AND
              weather_time <= UNIX_TIMESTAMP(NOW())
              AND
              city_id = :city_id
            ORDER BY id ASC LIMIT 12
              ';

        $statement = $this->pdo->prepare($query);
        $statement->execute(['city_id' => $cityId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * @return array
     */
    public function getCitiesWithCoordinates() {
        $finalData = [];
        $query = 'SELECT id, name, lat, lon FROM city';

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach($data as $item) {
            $finalData[$item['id']] = [
                'name' => $item['name'],
                'lat' => $item['lat'],
                'lon' => $item['lon'],
            ];
        }

        return $finalData;
    }
}