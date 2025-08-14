import React from 'react';
import ReactDOM from 'react-dom/client';
import List from './List';

const App = () => {
  return (
    <List /> // Listコンポーネントを直接描画
  );
};

const root = ReactDOM.createRoot(document.getElementById('react-root'));
root.render(<App />);