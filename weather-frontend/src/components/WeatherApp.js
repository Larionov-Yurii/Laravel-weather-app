import React, { useState } from 'react';
import axios from 'axios';
import InputForm from './InputForm';
import ForecastDetails from './ForecastDetails';
import ForecastTable from './ForecastTable';
import Notification from './Notification';
import '../App.css';

function WeatherApp() {
  const [cityName, setCityName] = useState('');
  const [forecast, setForecast] = useState(null);
  const [error, setError] = useState('');
  const [successMessage, setSuccessMessage] = useState('');
  const [isFromAPI, setIsFromAPI] = useState(false);

  const clearErrorAfterTimeout = () => {
    setTimeout(() => setError(''), 2000);
  };

  const clearSuccessMessageAfterTimeout = () => {
    setTimeout(() => setSuccessMessage(''), 2000);
  };

  // Formatting Date and Time from UNIX Timestamp
  const formatDateTimeWithAmPm = (timestamp, includeUTC = false) => {
    const date = new Date(timestamp * 1000);
    const hours = date.getUTCHours();
    const minutes = date.getUTCMinutes().toString().padStart(2, '0');
    const seconds = date.getUTCSeconds().toString().padStart(2, '0');
    const amPm = hours < 12 ? 'am' : 'pm';
    const formattedHours = (hours % 12 || 12).toString().padStart(2, '0');
    const datePart = date.toISOString().split('T')[0];
    return `${datePart} ${formattedHours}:${minutes}:${seconds} ${amPm} ${includeUTC ? 'UTC' : ''}`;
  };

  // Handle input change in the city input field
  const handleInputChange = (e) => setCityName(e.target.value);

  // Fetching weather forecast data from the API
  const fetchWeather = async () => {
    if (!cityName.trim()) {
      setError('City name cannot be empty');
      clearErrorAfterTimeout();
      return;
    }
    try {
      const response = await axios.post('http://localhost:8000/api/forecast/fetch', {
        city_name: cityName,
      });
      if (response.data.error) {
        setError(response.data.error);
      } else {
        setForecast(response.data);
        setIsFromAPI(true);
        setError('');
        setSuccessMessage('');
      }
      clearErrorAfterTimeout();
    } catch (error) {
      setError(error.response?.data?.error || 'Failed to fetch weather data');
      clearErrorAfterTimeout();
    }
  };

  // Saving forecast data to the database
  const saveForecast = async () => {
    if (!forecast) return;
    try {
      const response = await axios.post('http://localhost:8000/api/forecast/save', {
        city_name: forecast.city_name,
      });

      const { message } = response.data;
      setSuccessMessage(message === 'Forecast updated successfully.'
        ? 'Weather forecast updated successfully!'
        : 'Weather forecast saved successfully!');
      setError('');
      clearSuccessMessageAfterTimeout();
    } catch (error) {
      setError(error.response?.data?.error || 'Failed to save forecast');
      clearErrorAfterTimeout();
    }
  };

  // Loading forecast data from the database
  const loadForecast = async () => {
    if (!cityName.trim()) {
      setError('City name cannot be empty');
      clearErrorAfterTimeout();
      return;
    }
    try {
      const response = await axios.get('http://localhost:8000/api/forecast/load', {
        params: { city_name: cityName },
      });
      setForecast(response.data);
      setIsFromAPI(false);
      setError('');
      setSuccessMessage('');
    } catch (error) {
      setError(error.response?.data?.error || 'Failed to load forecast from database');
      clearErrorAfterTimeout();
    }
  };

  return (
    <div className="weather-app">
      <InputForm
        cityName={cityName}
        onInputChange={handleInputChange}
        onFetch={fetchWeather}
        onLoad={loadForecast}
      />
      <hr />
      <Notification message={error} type="error" />
      <Notification message={successMessage} type="success" />
      {forecast && (
        <>
          <ForecastDetails
            forecast={forecast}
            isFromAPI={isFromAPI}
            formatDateTimeWithAmPm={formatDateTimeWithAmPm}
            onSave={saveForecast}
          />
          <ForecastTable
            forecastPeriods={forecast.forecast_periods}
            formatDateTimeWithAmPm={formatDateTimeWithAmPm}
          />
        </>
      )}
    </div>
  );
}

export default WeatherApp;
