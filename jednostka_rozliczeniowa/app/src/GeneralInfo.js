import React, { useState, useEffect } from 'react'
import axios from 'axios'
import 'antd/dist/antd.css';
import { Collapse, Badge } from 'antd'

const GeneralInfo = () => {

  const [sessionSchedule, setSessionSchedule] = useState(null)

  const fetchSessionSchedule = () => {
    axios
      .get(`http://jr-api-express.herokuapp.com/api/session/schedule`)
      .then(response => {
        setSessionSchedule(response.data.schedule)
        
      })
      .catch(e => {
        console.log(e)
        setSessionSchedule(null)
      })
  }

  useEffect(fetchSessionSchedule, [])

  const copyrights = "Jednostka weryfikująca przelewy krajowe | &copy; Karol Lech, Przemysław Pleśniarski, Krzysztof Podkulski, Janusz Siek, Marcin Wielgos"

  return (
    <>
    <Badge status="processing" text={copyrights} />
    <Collapse defaultActiveKey={['1']} onChange={callback}>
    <Panel header="Aktualna konfiguracja sesji" key="sessionSchedule">
      {`Czas serwerowy: ${new Date().toLocaleString()}`}
      {
        sessionSchedule.map(s => {
          <Descriptions title={`Sesja: ${s.sessionName}`}>
            <Descriptions.Item label="Zamknięcie sesji">{s.hourClose}</Descriptions.Item>
            <Descriptions.Item label="Rozpoczęcie rozliczania (weryfikacje ręczne)">{s.hourStartClearance}</Descriptions.Item>
            <Descriptions.Item label="Zamknięcie rozliczania (zamknięcie weryfikacji ręcznych)">{s.hourStopClearance}</Descriptions.Item>
            <Descriptions.Item label="Zakończenie sesji (rozgłoszenie przelewów)">{s.hourAnnouce}</Descriptions.Item>
            <Descriptions.Item label="Granica kwoty do weryfikacji">{s.verifyBoundary}</Descriptions.Item>
          </Descriptions>
        })
      }
    </Panel>
    </Collapse>
    </>
  )
}

export default GeneralInfo