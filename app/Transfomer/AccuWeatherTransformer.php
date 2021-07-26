<?php

namespace App\Transfomer;

use App\Models\Info;
use App\Models\Weather;
use DateTime;

class AccuWeatherTransformer implements DataTransformerInterface
{
    public function transform($data)
    {
        $weathers = [];
        foreach ($data['DailyForecasts'] as $forecast) {
            $weather = new Weather();
            $dayInfo = new Info();
            $dayInfo
                ->setTitle($forecast['Day']['IconPhrase'])
                ->setHasPrecipitation($forecast['Day']['HasPrecipitation'])
            ;

            $nightInfo = new Info();
            $nightInfo
                ->setTitle($forecast['Night']['IconPhrase'])
                ->setHasPrecipitation($forecast['Night']['HasPrecipitation'])
            ;
            $weather
                ->setDate(new DateTime($forecast['Date']))
                ->setMinimum($forecast['Temperature']['Minimum']['Value'])
                ->setMaximum($forecast['Temperature']['Maximum']['Value'])
                ->setDayInfo($dayInfo)
                ->setNightInfo($nightInfo)
            ;

            $weathers[] = $weather;
        }
        return $weathers;
    }

    public function reverseTransform($data)
    {
    }

    public function mockResponse()
    {
        return json_decode("[
    {
        \"date\": \"Monday, 12/7/2020\",
        \"temperature\": {
            \"min\": 7.5,
            \"max\": 21.7
        },
        \"day\": {
            \"title\": \"Mostly cloudy\",
            \"hasPrecipitation\": false
        },
        \"night\": {
            \"title\": \"Mostly clear\",
            \"hasPrecipitation\": false
        }
    },
    {
        \"date\": \"Tuesday, 13/7/2020\",
        \"temperature\": {
            \"min\": 10.7,
            \"max\": 22.9
        },
        \"day\": {
            \"title\": \"Sunny\",
            \"hasPrecipitation\": false
        },
        \"night\": {
            \"title\": \"Clear\",
            \"hasPrecipitation\": false
        }
    },
    {
        \"date\": \"Wednesday, 14/7/2020\",
        \"temperature\": {
            \"min\": 13,
            \"max\": 24.3
        },
        \"day\": {
            \"title\": \"Sunny\",
            \"hasPrecipitation\": false
        },
        \"night\": {
            \"title\": \"Partly cloudy\",
            \"hasPrecipitation\": false
        }
    },
    {
        \"date\": \"Thursday, 15/7/2020\",
        \"temperature\": {
            \"min\": 9.9,
            \"max\": 23.6
        },
        \"day\": {
            \"title\": \"Sunny\",
            \"hasPrecipitation\": false
        },
        \"night\": {
            \"title\": \"Clear\",
            \"hasPrecipitation\": false
        }
    },
    {
        \"date\": \"Friday, 16/7/2020\",
        \"temperature\": {
            \"min\": 9.4,
            \"max\": 21
        },
        \"day\": {
            \"title\": \"Mostly sunny\",
            \"hasPrecipitation\": false
        },
        \"night\": {
            \"title\": \"Clear\",
            \"hasPrecipitation\": false
        }
    }
]", true);
    }
}
