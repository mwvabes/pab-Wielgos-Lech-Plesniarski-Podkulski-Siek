const mongoose = require("mongoose")

const bank = mongoose.model(
  "bank",
  new mongoose.Schema({
    bankID: String,
    bankName: String,
    bankBalance: Number,
    bankUnits: Array,
  },
  { timestamps: true })
)

module.exports = bank
