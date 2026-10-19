import './App.css'

function App() {
  const heading = window.wpData?.heroTitle || 'Helo wordpress react';

  return (
    <>
			<h1>{heading}</h1>
    </>
  )
}

export default App
