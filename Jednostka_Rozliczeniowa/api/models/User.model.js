const mongoose = require("mongoose")
const plm = require('passport-local-mongoose')

const user = mongoose.model(
  "user",
  new mongoose.Schema({
    username: { type: String, unique : true },
    bankIDs: Array,
    type: String
  },
  { timestamps: true }).plugin(plm, {usernameField: 'username'})
)

module.exports = user
