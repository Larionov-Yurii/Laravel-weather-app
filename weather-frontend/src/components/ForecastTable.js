import React from 'react';

function ForecastTable({ forecastPeriods, formatDateTimeWithAmPm }) {
  return (
    <div className="table-container">
      <div className="forecast-row header">
        <div>Datetime</div>
        <div>Min temp</div>
        <div>Max temp</div>
        <div>Wind speed</div>
      </div>
      {forecastPeriods.map((item, index) => (
        <div key={index} className="forecast-row data">
          <div>{formatDateTimeWithAmPm(item.timestamp_dt, false)}</div>
          <div>{item.min_tmp}°C</div>
          <div>{item.max_tmp}°C</div>
          <div>{item.wind_spd} km/h</div>
        </div>
      ))}
    </div>
  );
}

export default ForecastTable;
