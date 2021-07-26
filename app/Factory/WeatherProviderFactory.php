<?php

namespace App\Factory;

use App\Transfomer\AccuWeatherTransformer;
use App\WeatherProvider\AccuWeatherProvider;
use GuzzleHttp\Client;
use RuntimeException;

class WeatherProviderFactory
{
    const ACCU_WEATHER = 'accuweather';
    /**
     * @var Client
     */
    private $client;
    /**
     * @var AccuWeatherProvider
     */
    private $accuWeatherTransformer;

    /**
     * WeatherProviderFactory constructor.
     * @param Client $client
     * @param AccuWeatherTransformer $accuWeatherTransformer
     */
    public function __construct(Client $client, AccuWeatherTransformer $accuWeatherTransformer)
    {
        $this->client = $client;
        $this->accuWeatherTransformer = $accuWeatherTransformer;
    }

    public function createWeatherProvider(string $provider)
    {
        switch ($provider) {
            case self::ACCU_WEATHER:
                return new AccuWeatherProvider(
                    $this->client,
                    'aMY1E5aZAdseKe7sjUAgvTGJygoVBJI6',
                    $this->accuWeatherTransformer
                );
            default:
                throw new RuntimeException('Unable to find provider');
        }
    }
}
