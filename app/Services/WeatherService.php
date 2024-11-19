<?php

namespace App\Services;

use App\Models\Forecast;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    private $apiKey = 'e4b8b08c185638b825af37facfe1fabb';

    // Fetch weather data from OpenWeatherMap API
    public function fetchWeatherData($cityName)
    {
        $response = Http::get("http://api.openweathermap.org/data/2.5/forecast", [
            'q' => $cityName,
            'units' => 'metric',
            'appid' => $this->apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['list'])) {
                return $this->mapForecastData($data['list']);
            }
        }

        return ['error' => 'City not found or API error'];
    }

    // Save or update the forecast data for a city
    public function saveOrUpdateForecast($cityName)
    {
        // Fetch the latest forecast data
        $forecastData = $this->fetchWeatherData($cityName);

        if (isset($forecastData['error'])) {
        return $forecastData;
        }

        // Check if a forecast for this city already exists
        $existingForecast = Forecast::where('city_name', $cityName)->first();

        // Get the first forecast period
        $firstForecast = $forecastData[0];

        if ($existingForecast) {
            // Update the existing forecast if there are any differences
            $updated = false;
            if ($this->hasForecastChanged($existingForecast, $firstForecast)) {
                $existingForecast->update([
                    'timestamp_dt' => $firstForecast['timestamp_dt'],
                    'min_tmp' => $firstForecast['min_tmp'],
                    'max_tmp' => $firstForecast['max_tmp'],
                    'wind_spd' => $firstForecast['wind_spd'],
                ]);
                $updated = true;
            }

            return [
                'message' => $updated ? 'Forecast updated successfully.' : 'Forecast already up-to-date.',
                'forecast' => [$firstForecast],
            ];
        }

        // Save the first forecast
        Forecast::create([
            'city_name' => $cityName,
            'timestamp_dt' => $firstForecast['timestamp_dt'],
            'min_tmp' => $firstForecast['min_tmp'],
            'max_tmp' => $firstForecast['max_tmp'],
            'wind_spd' => $firstForecast['wind_spd'],
        ]);

        return [
            'message' => 'Forecast saved successfully.',
            'forecast' => [$firstForecast],
        ];
    }

    // Load forecast data for a city
    public function loadForecastData($cityName)
    {
        $forecast = Forecast::where('city_name', $cityName)->get();

        if ($forecast->isEmpty()) {
            return ['error' => 'Forecast not found'];
        }

        return [
            'city_name' => $cityName,
            'updated_at' => $forecast->first()->updated_at,
            'forecast_periods' => $forecast->map(function ($item) {
                return [
                    'timestamp_dt' => $item->timestamp_dt,
                    'min_tmp' => $item->min_tmp,
                    'max_tmp' => $item->max_tmp,
                    'wind_spd' => $item->wind_spd,
                ];
            }),
        ];
    }

    // Helper method to check if forecast data has changed
    private function hasForecastChanged($existingForecast, $newForecast)
    {
        return $existingForecast->timestamp_dt !== $newForecast['timestamp_dt'] ||
            $existingForecast->min_tmp !== $newForecast['min_tmp'] ||
            $existingForecast->max_tmp !== $newForecast['max_tmp'] ||
            $existingForecast->wind_spd !== $newForecast['wind_spd'];
    }

    /**
     * Method for transforming raw API forecast data into a structured array with data like:
     * temperature, wind speed, and forecast period time.
     */
    private function mapForecastData($list)
    {
        $forecasts = [];
        foreach ($list as $index => $forecastItem) {
            $startPeriod = $forecastItem['dt_txt'];
            $endPeriod = ($index < count($list) - 1) ? $list[$index + 1]['dt_txt'] : date('Y-m-d H:i:s', strtotime($startPeriod . ' +3 hours'));

            $forecasts[] = [
                'timestamp_dt' => $forecastItem['dt'],
                'min_tmp' => $forecastItem['main']['temp_min'],
                'max_tmp' => $forecastItem['main']['temp_max'],
                'wind_spd' => $forecastItem['wind']['speed'],
                'start_period' => $startPeriod,
                'end_period' => $endPeriod,
            ];
        }
        return $forecasts;
    }
}
