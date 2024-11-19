<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

class ForecastController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    // Save forecast to the database
    public function saveForecast(Request $request)
    {
        $request->validate(['city_name' => 'required|string']);
        $cityName = $request->input('city_name');

        // Delegate to the service to save or update forecast
        $result = $this->weatherService->saveOrUpdateForecast($cityName);

        if (isset($result['error'])) {
            return response()->json(['error' => $result['error']], 404);
        }

        return response()->json([
            'message' => $result['message'],
            'forecast' => $result['forecast']
        ], 200);
    }

    // Load forecast data from the database
    public function loadForecast(Request $request)
    {
        $request->validate(['city_name' => 'required|string']);
        $cityName = $request->input('city_name');

        // Delegate to the service to fetch forecast
        $forecastData = $this->weatherService->loadForecastData($cityName);

        if (isset($forecastData['error'])) {
            return response()->json(['error' => $forecastData['error']], 404);
        }

        return response()->json($forecastData, 200);
    }

    // Fetch latest weather data from API
    public function fetchWeather(Request $request)
    {
        $request->validate(['city_name' => 'required|string']);
        $cityName = $request->input('city_name');

        // Delegate to the service to fetch the forecast from external API
        $forecastData = $this->weatherService->fetchWeatherData($cityName);

        if (isset($forecastData['error'])) {
            return response()->json(['error' => $forecastData['error']], 404);
        }

        return response()->json([
            'city_name' => $cityName,
            'forecast_periods' => $forecastData
        ], 200);
    }
}

