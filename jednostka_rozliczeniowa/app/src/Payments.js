import React, { useState, useEffect } from 'react'
import axios from 'axios'
import 'antd/dist/antd.css';
import { Button, Divider, Table, message } from 'antd'

const PaymentConfirm = ({confirmPayment, declinePayment, paymentId, status}) => {
  
  if (status === "revision") {
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

    const params = {
      paymentId: paymentId,
      type: "confirm"
    }

    axios
      .post(`https://jr-api-express.herokuapp.com/api/payment/confirmation`, params)
      .then(response => {
        message.success('Zaakceptowano przelew')
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
        message.warning('Odrzucono przelew');
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