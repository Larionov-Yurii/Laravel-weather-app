import React from 'react';

function InputForm({ cityName, onInputChange, onFetch, onLoad }) {
  return (
    <div className="form-container">
      <input
        type="text"
        value={cityName}
        onChange={onInputChange}
        placeholder="Enter city name here (E.g Tel Aviv)"
        className="city-input"
      />
      <button className="fetch-btn" onClick={onFetch}>
        Get from API
      </button>
      <button className="load-btn" onClick={onLoad}>
        Get from DB
      </button>
    </div>
  );
}

export default InputForm;
