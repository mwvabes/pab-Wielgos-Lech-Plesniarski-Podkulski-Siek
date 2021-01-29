const passport = require('passport')
const models = require("../models")
const User = models.user

exports.passport = () => {
  passport.use(User.createStrategy())
}