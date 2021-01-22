import React, { useState, useEffect } from 'react'
import axios from 'axios'
import 'antd/dist/antd.css';
import { Button, Divider, Table, message, Alert } from 'antd'

const PaymentConfirm = ({confirmPayment, declinePayment, paymentId, status}) => {
  
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

const Payments = () => {

  const [paymentsInfo, setPaymentsInfo] = useState([])
  const [sessionStatus, setSessionStatus] = useState("Ładowanie informacji o sesji...")
  const [banksConf, setBanksConf] = useState(null)

  // const [formProductId, setFormProductId] = useState(null)
  // const [formAvailableQuantity, setFormAvailableQuantity] = useState(null)

  const fetchPayments = () => {
    axios
      .get(`https://jr-api-express.herokuapp.com/api/payment/getCurrentlyServed`)
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
      .post(`https://jr-api-express.herokuapp.com/api/payment/confirmation`, params)
      .then(response => {
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
      .post(`https://jr-api-express.herokuapp.com/api/payment/confirmation`, params)
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
      .post(`https://jr-api-express.herokuapp.com/api/payment/confirmation`, params)
      .then(response => {
        message.warning('Odrzucono przelew.');
        fetchPayments()
      })
  }

  const columns = [
    {
      title: 'Nadawca',
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
          t += " "
          t += unit.unitAddress
        }
        return <p>{t}</p>
      },
    },
    {
      title: 'Odbiorca',
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
          t += " "
          t += unit.unitAddress
        }
        return <p>{t}</p>
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
      render: (text, row) => <PaymentConfirm paymentId={row._id} status={row.paymentStatus} confirmPayment={confirmPayment} declinePayment={declinePayment} />,
    },
  ]

  return (
    <>
      <Divider orientation="left">{sessionStatus}</Divider>
      <Table columns={columns} dataSource={paymentsInfo} rowKey={paymentsInfo => paymentsInfo._id}
        
      />
    </>
  )
}

export default Payments