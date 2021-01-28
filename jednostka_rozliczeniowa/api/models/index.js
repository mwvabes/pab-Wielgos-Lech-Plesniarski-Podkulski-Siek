
const mongoose = require("mongoose")
mongoose.Promise = global.Promise

const db = {};

db.mongoose = mongoose;

db.bank = require("./Bank.model")
db.payment = require("./Payment.model")
db.user = require("./User.model")

module.exports = db