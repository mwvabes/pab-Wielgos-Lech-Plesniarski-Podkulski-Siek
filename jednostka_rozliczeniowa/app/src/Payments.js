import React, { useState, useEffect } from 'react'
import axios from 'axios'
import 'antd/dist/antd.css';
import { Button, Divider, Table, message, Alert, Spin } from 'antd'
import GeneralInfo from './GeneralInfo'

const PaymentConfirm = ({confirmPayment, declinePayment, reviseAgainPayment, paymentId, status}) => {
  
  if (status === "revision") {
    return (
      <>
        <Button onClick={() => confirmPayment(paymentId)} >Potwierdź</Button>
        <Button style={{ marginLeft: "20px" }} danger onClick={() => declinePayment(paymentId)} >Odrzuć</Button>
      </>
    )
  }
  else if (status === "accepted") {
    return (
      <>
        <Alert message="Przelew został zaakceptowany" type="success" showIcon />
        <Button style={{ marginLeft: "20px" }} danger onClick={() => reviseAgainPayment(paymentId)} >Anuluj</Button>
      </>
    )
  } 
  else if (status === "declined") {
    return (
      <>
        <Alert message="Przelew został odrzucony" type="error" showIcon />
        <Button style={{ marginLeft: "20px" }} danger onClick={() => reviseAgainPayment(paymentId)} >Anuluj</Button>
      </>
    )
  } else {
      return (
        <>
          <Alert message="Przelew został rozliczony automatycznie" type="info" showIcon />
          <Button style={{ marginLeft: "20px" }} danger onClick={() => reviseAgainPayment(paymentId)} >Anuluj</Button>
        </>
      )
  }

}

const Payments = ({ handleLogout }) => {

  const loadingSessionText = <><Spin /> Ładowanie informacji o sesji...</>

  const [paymentsInfo, setPaymentsInfo] = useState([])
  const [sessionStatus, setSessionStatus] = useState(loadingSessionText)
  const [banksConf, setBanksConf] = useState(null)

  const fetchPayments = () => {
    axios
      .get(`https://jr-api-express.herokuapp.com/api/payment/getCurrentlyServed`, {
        headers: {
          'Authorization': `${localStorage.getItem('jwt')}` 
        }})
      .then(response => {
        if (response.data.nosession) {
          setSessionStatus("Brak aktualnie obsługiwanej sesji")
          setPaymentsInfo([])
        } else {
          setSessionStatus(`Aktualnie obsługiwane przelewy sesji ${response.data.session}`)
          setPaymentsInfo(response.data.payments)
        }
        
      })
      .catch(e => console.log(e))
  }

  const fetchBanksConf = () => {
    axios
      .get(`https://jr-api-express.herokuapp.com/api/bank`)
      .then(response => {
        setBanksConf(response.data.banks)
      })
      .catch(e => setBanksConf(null))
  }

  useEffect(fetchPayments, [])
  useEffect(fetchBanksConf, [])

  const confirmPayment = (paymentId) => {

    const params = {
      paymentId: paymentId,
      type: "confirm"
    }

    axios
      .post(`https://jr-api-express.herokuapp.com/api/payment/confirmation`, params, {
        headers: {
          'Authorization': `${localStorage.getItem('jwt')}` 
        }}
      ).then(response => {
        message.success('Zaakceptowano przelew.')
        fetchPayments()
      })
  }


  const reviseAgainPayment = (paymentId) => {

    const params = {
      paymentId: paymentId,
      type: "revision"
    }

    axios
      .post(`https://jr-api-express.herokuapp.com/api/payment/confirmation`, params, {
        headers: {
          'Authorization': `${localStorage.getItem('jwt')}` 
        }})
      .then(response => {
        message.warning('Anulowano akcję. Przelew zamrożony.');
        fetchPayments()
      })
  }

  
  const declinePayment = (paymentId) => {

    const params = {
      paymentId: paymentId,
      type: "decline"
    }

    axios
      .post(`https://jr-api-express.herokuapp.com/api/payment/confirmation`, params, {
        headers: {
          'Authorization': `${localStorage.getItem('jwt')}` 
        }})
      .then(response => {
        message.warning('Odrzucono przelew.');
        fetchPayments()
      })
  }

  const columns = [
    {
      title: 'Nadawca >bank',
      dataIndex: 'senderAccountnumber',
      key: 'senderAccountnumber',
      render: text => {
        let t = ""
        if (banksConf != null) {
          const bank = banksConf.find(b => {
            return b.bankID === text.substring(4,7)
          })
          t += bank.bankName
          const unit = bank.bankUnits.find(u => {
            return u.unitID === text.substring(7, 12)
          })
        }
        return <p>{t}</p>
      },
    },
    {
      title: 'Nadawca >nazwa',
      dataIndex: 'senderName',
      key: 'senderName',
      render: text => {
        return <p>{text}</p>
      },
    },
    {
      title: 'Odbiorca >bank',
      dataIndex: 'recipientAccountnumber',
      key: 'recipientAccountnumber',
      render: text => {
        let t = ""
        if (banksConf != null) {
          const bank = banksConf.find(b => {
            return b.bankID === text.substring(4,7)
          })
          t += bank.bankName
          const unit = bank.bankUnits.find(u => {
            return u.unitID === text.substring(7, 12)
          })
        }
        return <p>{t}</p>
      },
    },
    {
      title: 'Odbiorca >nazwa',
      dataIndex: 'recipientName',
      key: 'recipientName',
      render: text => {
        return <p>{text}</p>
      },
    },
    {
      title: 'Tytułem',
      dataIndex: 'paymentTitle',
      key: 'paymentTitle',
      render: text => <p>{text}</p>,
    },
    {
      title: 'Kwota',
      dataIndex: 'paymentAmount',
      key: 'paymentAmount',
      render: text => <p>{text} PLN</p>,
    },
    {
      title: 'Szczegóły',
      dataIndex: '',
      key: 'confirmation',
      render: (text, row) => <PaymentConfirm paymentId={row._id} status={row.paymentStatus} confirmPayment={confirmPayment} declinePayment={declinePayment} reviseAgainPayment={reviseAgainPayment} />,
    },
  ]

  return (
    <>
      <GeneralInfo handleLogout={handleLogout} />
      <Divider orientation="left">{sessionStatus}</Divider>
      <Table columns={columns} dataSource={paymentsInfo} rowKey={paymentsInfo => paymentsInfo._id} />
    </>
  )
}

export default Payments