const fs = require('fs')
const axios = require('axios')
const banks = JSON.parse(fs.readFileSync('./conf/banks_conf.json'))
const validateNumber = require("../data/number.data")
const mongoose = require("mongoose")
const db = require('./../conf/dbconfig')
const schedule = require('node-schedule')

const auth = require('./auth.controller')

const sessionData = require('../data/session.data')
const paymentData = require('../data/payment.data')

const models = require("../models")
const Payment = models.payment

exports.addPaymentDisposition = (request, result) => {

  const myUser = request.user

  if (request.body.senderAccountnumber == undefined
    || request.body.recipientAccountnumber == undefined
    || request.body.paymentTitle == undefined
    || request.body.currency == undefined
    || request.body.paymentAmount == undefined) {

    result.status(400).json({
      isPaymentAccepted: false,
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
    message += `Błąd w numerze konta nadawcy: ${senderAccountnumber.comment}. `
    flag = true
  }

  if (recipientAccountnumber.status != 200) {
    message += `Błąd w numerze konta odbiorcy: ${recipientAccountnumber.comment}. `
    flag = true
  }

  let paymentStatus = "accepted"

  if (currency != "PLN") {
    message += `Nieobsługiwana waluta. `
    flag = true
  }

  if (paymentAmount > 1000000) {
    flag = true
    message += `Kwota przekracza 1000000 PLN. System obsługuje przelewy poniżej tej kwoty. `
  }

  if (paymentAmount > 1000 && paymentAmount <= 1000000 && flag == false) {
    paymentStatus = "revision"
    message += `Kwota przekracza 1000 PLN, przelew może zostać zlecony do zatwierdzenia ręcznego. `
  }



  if (flag) {
    result.status(400).json({
      isPaymentAccepted: false,
      message: `Przyjęcie przelewu odrzucone. ${message}`
    })
  }

  else {

    const senderBankCode = senderAccountnumber.accountnumber.substring(4, 7)
    const recipientBankCode = recipientAccountnumber.accountnumber.substring(4, 7)

    

    // if (!auth.checkIfHasAccessToBank(myUser, senderBankCode)) {
    //   result.status(400).json({
    //     isPaymentAccepted: false,
    //     message: `Niewystarczające uprawnienia. Przyjęcie przelewu odrzucone. ${message}`
    //   })
    //   return
    // }


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

    payment.save().then(r => {
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

  const myUser = request.user

  if (request.query.bankCode == undefined) {
    result.status(400).json({
      message: `Brakujące parametry zapytania`
    })
    return;
  }

  const sess = request.query.session == undefined ? sessionData.lastlyServedSession() : request.query.session

  if (!auth.checkIfHasAccessToBank(myUser, request.query.bankCode)) {
    result.status(400).json({
      message: `Niewystarczające uprawnienia`
    })
    return
  }

  mongoose.connect(db.url, db.attr)

  Payment.find({ servingSession: sess, "$or": [{
        recipientBankCode: request.query.bankCode, 
        "paymentStatus": "settled"
    }, {
        senderBankCode: request.query.bankCode,
        "paymentStatus": "declined"
    }] }).then(r => {
    result.status(200).json({
      sessionName: sess,
      r      
    })
  })

}

exports.settlePaymentsHandler = (request, result) => {

  const myUser = request.user

  if (!auth.checkIfAdmin(myUser)) {
    result.status(400).json({
      message: `Niewystarczające uprawnienia`
    })
    return
  }

  const r = paymentData.settlePayments()

  result.status(200).json({
    r
  })

}

exports.paymentConfirmation = (request, result) => {

  if (!auth.checkIfAdmin(myUser)) {
    result.status(400).json({
      message: `Niewystarczające uprawnienia`
    })
    return
  }

  console.log("Payment confirmation body", request.body)

  mongoose.connect(db.url, db.attr)

  if (request.body.type === "confirm") {
    Payment.update({ _id: request.body.paymentId }, { paymentStatus: "accepted" }).then(r => {
      result.status(200).json({
        r
      })
    })
  } else if (request.body.type === "revision") {
    Payment.update({ _id: request.body.paymentId }, { paymentStatus: "revision" }).then(r => {
      result.status(200).json({
        r
      })
    })
  } 
  else {
    Payment.update({ _id: request.body.paymentId }, { paymentStatus: "declined" }).then(r => {
      result.status(200).json({
        r
      })
    })
  }



}

exports.getCurrentlyServedPayments = (request, result) => {

  if (!auth.checkIfAdmin(myUser)) {
    result.status(400).json({
      message: `Niewystarczające uprawnienia`
    })
    return
  }

  const r = sessionData.getCurrentlyServedSession()

  if (r == null) {
    result.status(200).json({
      "message": "No current session",
      "nosession": true
    })
    return
  }

  paymentData.getCurrentlyServedPayments().then(payments => {
    result.status(200).json({
      "nosession": false,
      "session": r,
      "payments": payments
    })
  }

  )



  //   result.status(200).json({
  //   "nosession": false,
  //   "session": r
  //   //p
  // })



}


schedule.scheduleJob({ hour: 11, minute: 45 }, () => {
  console.log("Settling payments by scheduler _01")
  paymentData.settlePayments()
})

schedule.scheduleJob({ hour: 14, minute: 45 }, () => {
  console.log("Settling payments by scheduler _02")
  paymentData.settlePayments()
})

schedule.scheduleJob({ hour: 16, minute: 45 }, () => {
  console.log("Settling payments by scheduler _03")
  paymentData.settlePayments()
})

schedule.scheduleJob({ hour: 20, minute: 45 }, () => {
  console.log("Settling payments by scheduler _03")
  paymentData.settlePayments()
})

schedule.scheduleJob({ hour: 21, minute: 03 }, () => {
  console.log("Settling payments by scheduler _06")
  paymentData.settlePayments()
})
