const passport = require('passport')


// exports.auth1 = (request, result, next) => {
//   return passport.authenticate('jwt', { session: false })(request, result, next)
// }

const models = require("../models")
const User = models.user

exports.auth = (request, response, next) => {
    return passport.authenticate('myJwtStrategy', { session: false })(request, response, next)
}