<?php

use GuzzleHttp\Client;

class WeatherApi
{
    private $apiKey;
    private $baseUrl;

    /**
     * WeatherApi constructor.
     * @param $baseUrl
     * @param $apiKey
     */
    public function __construct($baseUrl, $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param $cityName
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchWeatherForCity($cityName) {
        $client = new Client();
        $res = $client->request(
            'GET',
            $this->appendAuthorizationKey(
                $this->baseUrl . 'weather?q=' . $cityName
            )
        );
        echo '<pre>' . var_export($this->appendAuthorizationKey(
                $this->baseUrl . 'weather?q=' . $cityName
            )) . '</pre>';
        $jsonEncoded = $res->getBody()->getContents();
        return json_decode($jsonEncoded, true);
    }

    /**
     * @param $cityName
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchWeatherHistoryForCity($cityName) {
        $client = new Client();
        $res = $client->request(
            'GET',
            $this->appendAuthorizationKey(
                $this->baseUrl . 'forecast?q=' . $cityName
            )
        );

        $jsonEncoded = $res->getBody()->getContents();
        return json_decode($jsonEncoded, true);
    }

    /**
     * @param $lon
     * @param $lat
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchWeatherDarkSkyForCity($lon, $lat) {
        $client = new Client();
        $res = $client->request(
            'GET',
            $this->appendDarkSkyAuthorizationKey(
                $this->baseUrl . $this->apiKey . '/' . $lon . ',' . $lat . '?units=uk'
            )
        );

        $jsonEncoded = $res->getBody()->getContents();
        return json_decode($jsonEncoded, true);
    }


    /**
     * @param $url
     * @return string
     */
    protected function appendDarkSkyAuthorizationKey($url){
        return $url;
    }

    /**
     * @param $url
     * @return string
     */
    protected function appendAuthorizationKey($url){
        return $url . '&APPID=' . $this->apiKey;
    }

}