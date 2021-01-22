const mongoose = require("mongoose")

const bank = mongoose.model(
  "bank",
  new mongoose.Schema({
    bankID: { type: String, unique : true },
    bankName: String,
    bankBalance: { type: mongoose.Types.Decimal128, default: 100000 },
    bankUnits: Array,
  },
  { timestamps: true })
)

module.exports = bank
