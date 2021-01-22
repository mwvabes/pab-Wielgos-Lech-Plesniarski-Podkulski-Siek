const fs = require('fs')
const sessionsConf = JSON.parse(fs.readFileSync('./conf/sessions_conf.json'))
const sessionData = require("../data/session.data")
const mongoose = require("mongoose")
const db = require('./../conf/dbconfig')

const models = require("../models")
const { settlePayments } = require('../controllers/payment.controller')
const Payment = models.payment

exports.settlePayments = () => {

  const session = sessionData.getCurrentlyServedSession()

  if (session == null) return ({ status: false, message: "Brak aktualnie obsługiwanej sesji" })

  mongoose.connect(db.url, db.attr)

  Payment.find({ servingSession: session, status: "accepted" }).then(p => {

    p.map(p => {
      Payment.findOneAndUpdate({ _id: p._id }, { status: "settled" }, { upsert: true })
      Bank.findOne({ bankID: p.senderBankCode }).then(b => {
        Bank.findOneAndUpdate({ bankID: p.senderBankCode }, { bankBalance: b.bankBalance - p.paymentAmount }, { upsert: true })
      })
      Bank.findOne({ bankID: p.recipientBankCode }).then(b => {
        Bank.findOneAndUpdate({ bankID: p.recipientBankCode }, { bankBalance: b.bankBalance + p.paymentAmount }, { upsert: true })
      })

    })

  })

  Payment.find({ servingSession: session, status: "revision" }).then(p => {

    p.map(p => {
      Payment.findOneAndUpdate({ _id: p._id }, { servingSession: sessionData.getCurrentSession() }, { upsert: true })
    })

  })

}

exports.acceptPayment = (paymentID) => {

  mongoose.connect(db.url, db.attr)

  Payment.findOneAndUpdate({ _id: paymentID, status: "revision" }, { status: "accepted" }, { upsert: true }).then(r => {
    return 200;
  }).catch(e => {
    return 400;
  })

}

exports.cancelPayment = (paymentID) => {

  mongoose.connect(db.url, db.attr)

  Payment.findOneAndUpdate({ _id: paymentID, status: "revision" }, { status: "cancelled" }, { upsert: true }).then(r => {
    return 200;
  }).catch(e => {
    return 400;
  })

}

exports.getCurrentlyServedPayments = () => {

  const p = new Promise((resolve, reject) => {
    const currentSession = sessionData.getCurrentlyServedSession()

    mongoose.connect(db.url, db.attr)

    Payment.find({ servingSession: currentSession }).then(r => {
      resolve(r)
    }).catch(e => {
      reject(400)
    })

  })

  return p

}

