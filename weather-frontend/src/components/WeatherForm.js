import React from 'react';

function WeatherForm({ cityName, setCityName, fetchWeather, loadForecast }) {
  return (
    <div className="form-container">
      <input
        type="text"
        value={cityName}
        onChange={(e) => setCityName(e.target.value)}
        placeholder="Enter city name (e.g., Tel Aviv)"
        className="city-input"
      />
      <button className="fetch-btn" onClick={fetchWeather}>
        Get from API
      </button>
      <button className="load-btn" onClick={loadForecast}>
        Get from DB
      </button>
    </div>
  );
}

export default WeatherForm;
