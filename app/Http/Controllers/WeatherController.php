<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Factory\WeatherProviderFactory;
use App\Response\ApiResponse;
use Illuminate\Routing\Controller as BaseController;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WeatherController extends BaseController
{
    const CITY_QUERYSTRING = 'city';

    /**
     * @var WeatherProviderFactory
     */
    private $providerFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * WeatherController constructor.
     * @param WeatherProviderFactory $factory
     * @param LoggerInterface $logger
     */
    public function __construct(WeatherProviderFactory $factory, LoggerInterface $logger)
    {
        $this->providerFactory = $factory;
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidRequestException
     */
    public function listAction(Request $request): JsonResponse
    {
        if (!$request->query->has(self::CITY_QUERYSTRING)) {
            throw new InvalidRequestException();
        }

        $useMock = false;
        if ($request->query->has('useMock')) {
            $useMock = $request->query->get('useMock') === 'true';
        }

        // this will allow us to extend to different providers in the future without much
        // code changes
        $data = $this->providerFactory
            ->createWeatherProvider(WeatherProviderFactory::ACCU_WEATHER)
            ->get($request->query->get(self::CITY_QUERYSTRING), $useMock);

        return ApiResponse::generateHttpResponse($data);
    }
}
