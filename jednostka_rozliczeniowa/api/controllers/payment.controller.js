const fs = require('fs')
const axios = require('axios')
const banks = JSON.parse(fs.readFileSync('./conf/banks_conf.json'))
const validateNumber = require("../data/number.data")
const mongoose = require("mongoose")
const db = require('./../conf/dbconfig')

const sessionData = require('../data/session.data')
const paymentData = require('../data/payment.data')

const models = require("../models")
const Payment = models.payment

exports.addPaymentDisposition = (request, result) => {

  if (request.body.senderAccountnumber == undefined
    || request.body.recipientAccountnumber == undefined
    || request.body.paymentTitle == undefined
    || request.body.currency == undefined
    || request.body.paymentAmount == undefined) {

    result.status(400).json({
      message: "Niepoprawne parametry zapytania"
    })
    return
  }

  const senderAccountnumber = validateNumber.validateNumber(request.body.senderAccountnumber)
  const recipientAccountnumber = validateNumber.validateNumber(request.body.recipientAccountnumber)
  const paymentTitle = request.body.paymentTitle
  const paymentAmount = request.body.paymentAmount
  const currency = request.body.currency

  mongoose.connect(db.url, db.attr)

  let message = "";
  let flag = false

  if (senderAccountnumber.status != 200) {
    message += `Błąd w numerze konta nadawcy: ${senderAccountnumber.comment} | `
    flag = true
  }

  if (recipientAccountnumber.status != 200) {
    message += `Błąd w numerze konta odbiorcy: ${recipientAccountnumber.comment} | `
    flag = true
  }

  let paymentStatus = "accepted"

  if (currency != "PLN") {
    message += `Nieobsługiwana waluta | `
    flag = true
  }

  if (paymentAmount > 1000 && flag == false) {
    paymentStatus = "revision"
    message += `| Kwota przekracza 1000 PLN, przelew może zostać zlecony do zatwierdzenia ręcznego | `
  }

  if (flag) {
    result.status(400).json({
      isPaymentAccepted: false,
      message: `||| Przyjęcie przelewu odrzucone ||| ${message}`
    })
  }

  else {

    const senderBankCode = senderAccountnumber.accountnumber.substring(4, 7)
    const recipientBankCode = recipientAccountnumber.accountnumber.substring(4, 7)



    const payment = new Payment({
      senderAccountnumber: senderAccountnumber.accountnumber,
      senderBankCode,
      recipientAccountnumber: recipientAccountnumber.accountnumber,
      recipientBankCode,
      paymentTitle: paymentTitle,
      paymentAmount: paymentAmount,
      delegatingSession: sessionData.getCurrentSession(),
      servingSession: sessionData.getCurrentSession(),
      paymentStatus: paymentStatus
    })

    console.log("PAY", payment)

    payment.save().then(r => {
      console.log('Payment saved!')
      mongoose.connection.close()
      result.status(200).json({
        isPaymentAccepted: true,
        message: `Zlecenie przelewu zostało przyjęte do realizacji ${message} `,
        payment
      })

    })
  }

}

exports.getIncomingPayments = (request, result) => {

  if (request.query.bankCode == undefined ||
    request.query.session == undefined) {
    result.status(400).json({
      message: `Brakujące parametry zapytania`
    })
    return;
  }

  mongoose.connect(db.url, db.attr)

  Payment.find({ servingSession: request.query.session, recipientBankCode: request.query.bankCode }).then(r => {
    result.status(200).json({
      r
    })
  })

}

exports.settlePayments = (request, result) => {

  const r = paymentData.settlePayments()

  result.status(200).json({
    r
  })

}

exports.getCurrentlyServedPayments = (request, result) => {

  const r = paymentData.getCurrentlyServedPayments()

  result.status(200).json({
    r
  })

}


