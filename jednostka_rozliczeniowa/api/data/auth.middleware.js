const passport = require('passport')
const passportConf = require('./conf/passport')


exports.auth = (request, result, next) => {
  passportConf.passport()
  return passport.authenticate('jwt', { session: false })(request, result, next)
}