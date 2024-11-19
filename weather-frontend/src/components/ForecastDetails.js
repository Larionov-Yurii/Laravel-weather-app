import React from 'react';

function ForecastDetails({ forecast, isFromAPI, formatDateTimeWithAmPm, onSave }) {
  return (
    <div className="forecast-details-container">
      <h3>{forecast.city_name}</h3>
      <div className="period">
        {isFromAPI ? (
          <p>
            <strong>Period</strong>
          </p>
        ) : (
          <p>
            <strong>Updated at:</strong>{' '}
            <span className="updated-text">
              {formatDateTimeWithAmPm(new Date(forecast.updated_at).getTime() / 1000, true)}
            </span>
          </p>
        )}

        {isFromAPI && forecast.forecast_periods.length > 0 && (
          <div>
            <p>
              Starts at: {formatDateTimeWithAmPm(forecast.forecast_periods[0].timestamp_dt, false)}
            </p>
            <p>
              Ends at:{' '}
              {formatDateTimeWithAmPm(
                forecast.forecast_periods[forecast.forecast_periods.length - 1].timestamp_dt,
                false
              )}
            </p>
          </div>
        )}
      </div>
      {isFromAPI && (
        <button className="save-btn" onClick={onSave} disabled={!forecast}>
          Save Forecast
        </button>
      )}
    </div>
  );
}

export default ForecastDetails;
