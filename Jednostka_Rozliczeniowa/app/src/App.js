import React, { useState } from 'react'
import './reset.css'
import 'antd/dist/antd.css'
import './Login.css'
import './App.css'
import Payments from './Payments'
import Login from './Login'

const App = () => {

  const [welcomeMessage, setWelcomeMessage] = useState("Zaloguj się, aby uzyskać dostęp")
  const [isTokenExpired, setIsTokenExpired] = useState(null)

  const handleTokenExpirationStatusChange = (bool) => {
    setIsTokenExpired(bool)
  }  

  const handleLogout = () => {
    handleTokenExpirationStatusChange(null)
    setWelcomeMessage("Wylogowano")
  }

  return (
    <>
      {isTokenExpired === false ? 
        <div className="container"><Payments handleLogout={handleLogout} /></div> :
      <Login welcomeMessage={welcomeMessage} handleTokenExpirationStatusChange={handleTokenExpirationStatusChange} />
      }
    </>
  );
}

export default App
