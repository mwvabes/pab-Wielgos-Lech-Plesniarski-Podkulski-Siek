const mongoose = require("mongoose")

const payment = mongoose.model(
  "payment",
  new mongoose.Schema({
    senderAccountnumber: String,
    senderBankCode: String,
    recipientAccountnumber: String,
    recipientBankCode: String,
    paymentTitle: String,
    paymentAmount: Number,
    delegatingSession: String,
    servingSession: String,
    paymentStatus: String
  },
  { timestamps: true })
)

module.exports = payment
