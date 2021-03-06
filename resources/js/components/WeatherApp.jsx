import React, {useState} from 'react';
import ReactDOM from 'react-dom';
import CitySelector from "./CitySelector";
import fetch from 'node-fetch';

function WeatherApp() {
    const weatherApiEndpoint = 'http://127.0.0.1:8000/api/weather';
    const [weathers, setWeathers] = useState([]);
    const [useMock, setUseMock] = useState(false);

    const fetchWeather = (city) => {
        let url = weatherApiEndpoint + '?city=' + city.name + '&useMock=' + useMock

        return fetch(url);
    }

    const handleOnChange = (event) => {
        setUseMock(event.target.checked);
    }

    const handleOnCitySelect = async (city) => {
        try {
            const response = await fetchWeather(city);
            const data = await response.json();

            setWeathers(data.result);
        } catch (error) {
            console.log(error);
            setWeathers([]);
        }
    }

    const generateWeatherBlock = () => {
        if (!weathers) {
            return null;
        }
        return weathers.map((weather, index) => {
            return <div className="rounded shadow-lg" key={index}>
                <div className="px-6 py-4">
                    <div className="font-bold text-xl mb-2">{weather.date}</div>
                    <div className="font-bold text-l mb-2">Day</div>
                    <p className="text-gray-700 text-base mb-3">
                        {weather.day.title}
                    </p>
                    <div className="font-bold text-l mb-2">Night</div>
                    <p className="text-gray-700 text-base mb-3">
                        {weather.night.title}
                    </p>
                    <div className="font-bold text-l mb-2">Temperature</div>
                    <p className="text-gray-700 text-base">
                        <span>Max: {weather.temperature.max}</span>
                        <br/>
                        <span>Max: {weather.temperature.min}</span>
                    </p>
                </div>
            </div>
        });
    }

    return (
        <>
            <div className="flex justify-center mt-10">
                <h1 className="font-bold text-4xl">Please select a city to being.</h1>
            </div>
            <div className="flex justify-center mt-28">
                <div className="grid grid-rows-1 grid-flow-col gap-4">
                    <CitySelector onSelect={handleOnCitySelect}/>
                </div>
            </div>
            <div className="flex justify-center mt-10 mb-28">
                <div className="grid grid-rows-1 grid-flow-col gap-4">
                    Use mock data: <input type="checkbox" onChange={handleOnChange}/>
                </div>
            </div>

            <div className="flex justify-center m">
                <div className="grid grid-rows-1 grid-flow-col gap-4">
                    {generateWeatherBlock()}
                </div>
            </div>

        </>
    )
}

export default WeatherApp;

if (document.getElementById('react-container')) {
    ReactDOM.render(<WeatherApp/>, document.getElementById('react-container'));
}
