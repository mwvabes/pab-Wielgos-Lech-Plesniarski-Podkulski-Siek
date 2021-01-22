const fs = require('fs')
const sessionsConf = JSON.parse(fs.readFileSync('./conf/sessions_conf.json'))
const banksConf = JSON.parse(fs.readFileSync('./conf/banks_conf.json'))
const sessionData = require("../data/session.data")
const mongoose = require("mongoose")
const db = require('./../conf/dbconfig')

const models = require("../models")
const Payment = models.payment
const Bank = models.bank

exports.settlePayments = () => {

  const session = sessionData.getCurrentlyServedSession()

  if (session == null) return ({ status: false, message: "Brak aktualnie obsługiwanej sesji" })

  mongoose.connect(db.url, db.attr)

  Payment.find({ servingSession: session, paymentStatus: "accepted" }).then(parr => {

    parr.map(p => {
      return Payment.updateOne({ _id: p._id }, { paymentStatus: "settled" }).then(x => {
 
        Bank.findOne({ bankID: p.senderBankCode }).then(b => {
    
          Bank.updateOne({ bankID: p.senderBankCode }, { bankBalance: b.bankBalance - p.paymentAmount }, { upsert: true }).catch(e => console.log(e))

          
        }).catch(e => console.log(e))
        Bank.findOne({ bankID: p.recipientBankCode }).then(b => {
          
          Bank.updateOne({ bankID: p.recipientBankCode }, { bankBalance: b.bankBalance + p.paymentAmount }, { upsert: true }).catch(e => console.log(e))

        }).catch(e => console.log(e))
      }).catch(e => console.log(e))


    })

  })

  Payment.find({ servingSession: session, status: "revision" }).then(p => {

    p.map(p => {
      Payment.findOneAndUpdate({ _id: p._id }, { servingSession: sessionData.getCurrentSession() }, { upsert: true })
    })

  })

  return;

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

    Payment.find({ servingSession: currentSession }).sort( { "paymentStatus": 1, "_id": 1 } ).then(r => {
      resolve(r)
    }).catch(e => {
      reject(400)
    })

  })

  return p

}

