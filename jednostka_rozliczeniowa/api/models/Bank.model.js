const mongoose = require("mongoose")

const bank = mongoose.model(
  "bank",
  new mongoose.Schema({
    bankID: String,
    bankName: String,
    bankBalance: { type: Number, default: 100000 },
    bankUnits: Array,
  },
  { timestamps: true })
)

module.exports = bank
