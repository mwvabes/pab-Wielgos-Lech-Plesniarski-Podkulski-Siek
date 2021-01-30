const mongoose = require("mongoose")

const payment = mongoose.model(
  "payment",
  new mongoose.Schema({
    senderAccountnumber: String,
    senderBankCode: String,
    senderName: String,
    senderAddress: String,
    recipientAccountnumber: String,
    recipientBankCode: String,
    recipientName: String,
    recipientAddress: String,
    paymentTitle: String,
    paymentAmount: Number,
    delegatingSession: String,
    servingSession: String,
    paymentStatus: String
  },
  { timestamps: true })
)

module.exports = payment
