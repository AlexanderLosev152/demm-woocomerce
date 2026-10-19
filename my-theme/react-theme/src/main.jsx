import App from './App.jsx';
import { createRoot } from 'react-dom/client';
import './App.css';

const rootElement = document.getElementById('root');

if (!rootElement) {
  throw new Error('React root element #root was not found in the WordPress template.');
}

createRoot(rootElement).render(<App />);
