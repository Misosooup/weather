<?php

namespace App\WeatherProvider;

use App\Transfomer\DataTransformerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

abstract class WeatherProvider
{
    /**
     * @var Client
     */
    protected $client;

    /** @var string */
    protected $apiKey;
    /**
     * @var DataTransformerInterface
     */
    protected $dataTransformer;

    /**
     * OpenWeatherProvider constructor.
     * @param Client $client
     * @param string $apiKey
     * @param DataTransformerInterface $dataTransformer
     */
    public function __construct(Client $client, string $apiKey, DataTransformerInterface $dataTransformer)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->dataTransformer = $dataTransformer;
    }

    /**
     * Get the specific endpoint of the provider
     * @return string
     */
    protected abstract function generateUrl(string $city): string;

    protected abstract function parseBody(string $rawResponse);

    /**
     * Fetch the results
     * @param string $city
     * @param bool $useMock
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function get(string $city, bool $useMock = false)
    {
        if ($useMock) {
            return $this->dataTransformer->mockResponse();
        }

        $response = $this->client->request(Request::METHOD_GET, $this->generateUrl($city));
        $responseData = $this->parseBody($response->getBody()->getContents());

        return $this->dataTransformer->transform($responseData);
    }
}
