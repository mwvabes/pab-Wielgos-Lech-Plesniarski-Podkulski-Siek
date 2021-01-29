import React, { useState } from "react";
import axios from "axios";
import {
  Button,
  Input,
  Form,
  Alert,
  Badge
} from "antd";

const LoginInputs = ({ welcomeMessage, handleTokenExpirationStatusChange }) => {

  const [loginInput, setLoginInput] = useState(null)
  const [passwordInput, setPasswordInput] = useState(null)
  const [isLoginIncorrect, setIsLoginIncorrect] = useState(null)

  const handleLogin = () => {
    
    const password = passwordInput
    const params = {
      username: loginInput,
      password: password
    }
    setPasswordInput()

    axios
      .post(`https://jr-api-express.herokuapp.com/api/auth/login`, params)
      .then(response => {
        setIsLoginIncorrect(false)

        localStorage.clear()
        localStorage.setItem('jwt', response.data.token)

        setTimeout(() => {
          handleTokenExpirationStatusChange(false)
        }, 1000)

        
      }).catch(e => {
        setIsLoginIncorrect(true)
      })

  }

  const handleLoginChange = (e) => {
    setLoginInput(e.target.value)
  }

  const handlePasswordChange = (e) => {
    setPasswordInput(e.target.value)
  }

  return (
    <>
      <div className="inputsWrapper">
        <h1>{welcomeMessage}</h1>
        <div className="inputsBox">
          <Form
            name="login"
            initialValues={{ remember: true }}
            onFinish={() => {}}
            onFinishFailed={() => {}}
          >
            <Form.Item name="operatorLogin">
              <Input placeholder="Login" onChange={e => handleLoginChange(e)} />
            </Form.Item>

            <Form.Item name="operatorPassword">
              <Input.Password placeholder="Hasło" onChange={e => handlePasswordChange(e)} />
            </Form.Item>

            <Form.Item>
              <Button type="primary" htmlType="submit" onClick={() => handleLogin()}>
                Zaloguj
              </Button>
            </Form.Item>
          </Form>

          {isLoginIncorrect === true ? <Alert message={<Badge status="error" text="Błędne logowanie. Spróbuj ponownie." />} type="error" style={{margin: "10px 0px"}} /> : isLoginIncorrect === false ? <Alert message={<Badge status="success" text="Logowanie poprawne. Za chwilę zostaniesz przekierowany do panelu..." />} type="success" style={{margin: "10px 0px"}} /> : "" }

        </div>
      </div>
    </>
  );
};

const Login = ({ welcomeMessage, handleTokenExpirationStatusChange }) => {
  return (
    <>
      <div className="loginWrapper">
        <div className="loginLeftWrapper">
          <div className="loginLeft">
            <div className="loginLeftMain">JR</div>
            <div className="loginLeftEnhance">
              <p>Jednostka Rozliczeniowa</p>
              <p>Moduł weryfikujący przelewy krajowe ELIXIR</p>
            </div>
          </div>
        </div>
        <div className="loginRight">
          <header></header>
          <LoginInputs welcomeMessage={welcomeMessage} handleTokenExpirationStatusChange={handleTokenExpirationStatusChange} />
          <footer>
            &copy; 2020 - 21 by Karol Lech, Przemysław Pleśniarski, Krzysztof
            Podkulski, Janusz Siek, Marcin Wielgos
          </footer>
        </div>
      </div>
    </>
  )
}

export default Login
