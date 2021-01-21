import React, { useState, useEffect } from 'react'
import axios from 'axios'
import 'antd/dist/antd.css';
import { Collapse, Badge, Descriptions, Alert } from 'antd'

const { Panel } = Collapse

const GeneralInfo = () => {

  const [sessionSchedule, setSessionSchedule] = useState(null)

  const fetchSessionSchedule = () => {
    axios
      .get(`https://jr-api-express.herokuapp.com/api/session/schedule`)
      .then(response => {
        setSessionSchedule(response.data.schedule)
        
      })
      .catch(e => {
        console.log(e)
        setSessionSchedule(null)
      })
  }

  useEffect(fetchSessionSchedule, [])

  const copyrights = `Jednostka weryfikująca przelewy krajowe | ${"\u00A9"} 2020-21 Karol Lech, Przemysław Pleśniarski, Krzysztof Podkulski, Janusz Siek, Marcin Wielgos`

  return (
    <>
    <Alert message={<Badge status="processing" text={copyrights} />} type="info" style={{margin: "10px 0px"}} />
    
    <Collapse defaultActiveKey={['1']}>
    <Panel header="Aktualna konfiguracja sesji" key="sessionSchedule" extra={<a href="https://jr-api-express.herokuapp.com/">API</a>}>
      {`Czas serwerowy: ${new Date().toLocaleString()}`}
      {
        sessionSchedule !== null ? sessionSchedule.map(s => { 
          return <Descriptions title={`Sesja: ${s.sessionName}`} key={`session^${s.sessionName}`} style={{marginBottom: "20px"}} bordered size="small" column={{ xxl: 2, xl: 2, lg: 2, md: 2, sm: 2, xs: 1 }}>
            <Descriptions.Item label="Zamknięcie sesji">{s.hourClose}</Descriptions.Item>
            <Descriptions.Item label="Rozpoczęcie rozliczania (weryfikacje ręczne)">{s.hourStartClearance}</Descriptions.Item>
            <Descriptions.Item label="Zamknięcie rozliczania (zamknięcie weryfikacji ręcznych)">{s.hourStopClearance}</Descriptions.Item>
            <Descriptions.Item label="Zakończenie sesji (rozgłoszenie przelewów)">{s.hourAnnounce}</Descriptions.Item>
            <Descriptions.Item label="Granica kwoty do weryfikacji">{s.verifyBoundary}</Descriptions.Item>
          </Descriptions>
        })
       : ""}
    </Panel>
    </Collapse>
    </>
  )
}

export default GeneralInfo