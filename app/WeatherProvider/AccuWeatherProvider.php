<?php

namespace App\WeatherProvider;

use GuzzleHttp\Exception\GuzzleException;

class AccuWeatherProvider extends WeatherProvider
{
    private $baseUrl = 'http://dataservice.accuweather.com';

    /**
     * @param string $city
     * @return string
     * @throws GuzzleException
     */
    protected function generateUrl(string $city): string
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl . sprintf('/locations/v1/cities/search?q=%s&apikey=%s', $city, $this->apiKey),
        );

        $data = $this->parseBody($response->getBody()->getContents());
        $cityKey = $data[0]['Key'];

        return $this->baseUrl . sprintf('/forecasts/v1/daily/5day/%s?apikey=%s&metric=true', $cityKey, $this->apiKey);
    }

    /**
     * @param string $rawResponse
     * @return array
     */
    protected function parseBody(string $rawResponse): array
    {
        return json_decode($rawResponse, true);
    }
}
