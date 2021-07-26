<?php

namespace App\Console\Commands;

use App\Factory\WeatherProviderFactory;
use Exception;
use Illuminate\Console\Command;

class GetWeather extends Command
{
    const DELIMITER = ',';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch {provider} {cities} {--useMock}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Fetch weather by city names.";
    /**
     * @var WeatherProviderFactory
     */
    private $factory;

    /**
     * Create a new command instance.
     *
     * @param WeatherProviderFactory $factory
     */
    public function __construct(WeatherProviderFactory $factory)
    {
        parent::__construct();
        $this->factory = $factory;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $providerInput = $this->argument('provider');
        $citiesInput = $this->argument('cities');
        $useMock = $this->option('useMock');

        $cities = explode(self::DELIMITER, $citiesInput);

        try {
            $weatherProvider = $this->factory->createWeatherProvider($providerInput);

            foreach ($cities as $city) {
                $result = $weatherProvider->get($city, $useMock);

                $tableNode = [];
                foreach ($result as $data) {
                    $tableNode[] = [
                        $data['date'],
                        'Day: ' . $data['day']['title'],
                        'Night: ' . $data['night']['title'],
                        $data['temperature']['min'],
                        $data['temperature']['max']
                    ];
                }
                $this->info($city);
                $this->table(['date', 'dayType', 'nightType', 'min', 'max'], $tableNode);
            }
        } catch (Exception $e) {
            $this->error('We have encountered an error when fetching your weather information.');
            if ($this->option('verbose')) {
                $this->info($e->getTraceAsString());
            }
        }

        return 0;
    }
}
