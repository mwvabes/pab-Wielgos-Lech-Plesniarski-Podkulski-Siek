const passport = require('passport')
const passportConf = require('./../conf/passport')


exports.auth = (request, result, next) => {
  return passport.authenticate('jwt', { session: false })(request, result, next)
}