import React, { useState, useEffect } from 'react'
import axios from 'axios'
import 'antd/dist/antd.css';
import { Button, Divider, Table, Form, Input, InputNumber, Space, List } from 'antd'

const Payments = () => {

  const [paymentsInfo, setPaymentsInfo] = useState([])

  // const [formProductId, setFormProductId] = useState(null)
  // const [formAvailableQuantity, setFormAvailableQuantity] = useState(null)

  const fetchPayments = () => {
    axios
      .get(`http://localhost:8005/api/payments/getCurrentlyServed`)
      .then(response => {
        console.log(response)
        setPaymentsInfo(response.data)
      })
      .catch(e => console.log(e))
  }

  useEffect(fetchPayments, [])

  const confirmParcelArrival = (parcelId) => {
    axios
      .post(`http://localhost:8005/api/payments/getCurrentlyServed`)
      .then(response => {
        fetchPayments()
      })
  }

  const columns = [
    {
      title: 'Nadawca',
      dataIndex: 'sender',
      key: 'sender',
      render: text => <a>{text}</a>,
    },
    {
      title: 'Odbiorca',
      dataIndex: 'sender',
      key: 'sender',
      render: text => <a>{text}</a>,
    },
    {
      title: 'Kwota',
      dataIndex: 'sender',
      key: 'sender',
      render: text => <a>{text}</a>,
    },
    {
      title: 'Szczegóły',
      dataIndex: 'parcelSettings',
      key: 'sender',
      render: (text, row) => <p>{text}</p>,
    },
  ]

  return (
    <>
      <Divider orientation="left">Aktualnie obsługiwane przelewy</Divider>
      <Table columns={columns} dataSource={paymentsInfo} rowKey={paymentsInfo => paymentsInfo._id}
        
      />
    </>
  )
}

export default Payments