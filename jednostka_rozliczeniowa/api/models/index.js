
const mongoose = require("mongoose")
mongoose.Promise = global.Promise

const db = {};

db.mongoose = mongoose;

db.bank = require("./Bank.model")
db.payment = require("./Payment.model")

module.exports = db