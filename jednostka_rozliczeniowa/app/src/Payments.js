import React, { useState, useEffect } from 'react'
import axios from 'axios'
import 'antd/dist/antd.css';
import { Button, Divider, Table } from 'antd'

const PaymentConfirm = ({confirmPayment, declinePayment, paymentId, status}) => {
  
  if (status === "in_shipping") {
    return (
      <>
        <Button onClick={() => confirmPayment(paymentId)} >Potwierdź</Button>
        <Button danger onClick={() => declinePayment(paymentId)} >Odrzuć</Button>
      </>
    )
  }
  else {
    return (
      <>
        <p>Operacja nie wymaga żadnej akcji</p>
      </>
    )
  }

}

const Payments = () => {

  const [paymentsInfo, setPaymentsInfo] = useState([])
  const [sessionStatus, setSessionStatus] = useState("Ładowanie informacji o sesji...")

  // const [formProductId, setFormProductId] = useState(null)
  // const [formAvailableQuantity, setFormAvailableQuantity] = useState(null)

  const fetchPayments = () => {
    axios
      .get(`https://jr-api-express.herokuapp.com/api/payment/getCurrentlyServed`)
      .then(response => {
        console.log("RES", response.data)
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

  useEffect(fetchPayments, [])

  const confirmPayment = (paymentId) => {
    axios
      .post(`https://jr-api-express.herokuapp.com/api/payments/getCurrentlyServed`, null, {paymentId})
      .then(response => {
        fetchPayments()
      })
  }

  
  const declinePayment = (paymentId) => {
    axios
      .post(`https://jr-api-express.herokuapp.com/api/payments/getCurrentlyServed`, null, {paymentId})
      .then(response => {
        fetchPayments()
      })
  }

  const columns = [
    {
      title: 'Nadawca',
      dataIndex: 'senderAccountnumber',
      key: 'senderAccountnumber',
      render: text => <p>{text}</p>,
    },
    {
      title: 'Odbiorca',
      dataIndex: 'recipientAccountnumber',
      key: 'recipientAccountnumber',
      render: text => <a>{text}</a>,
    },
    {
      title: 'Kwota',
      dataIndex: 'paymentAmount',
      key: 'paymentAmount',
      render: text => <a>{text}</a>,
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