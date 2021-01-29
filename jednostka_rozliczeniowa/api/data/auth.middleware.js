const passport = require('passport')

exports.auth = (request, result, next) => {
  return passport.authenticate('jwt', { session: false })(request, result, next)
}