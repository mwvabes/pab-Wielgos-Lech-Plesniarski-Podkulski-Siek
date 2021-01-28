const mongoose = require("mongoose")
import plm from 'passport-local-mongoose'

const user = mongoose.model(
  "user",
  new mongoose.Schema({
    username: { type: String, unique : true },
    bankIDs: Array,
    type: String
  },
  { timestamps: true })
)

user.plugin(plm, {usernameField: 'username'})

module.exports = user
