import React from 'react';

function Notification({ message, type }) {
  if (!message) return null;

  const className = type === 'error' ? 'error' : 'success';
  return <p className={className}>{message}</p>;
}

export default Notification;
