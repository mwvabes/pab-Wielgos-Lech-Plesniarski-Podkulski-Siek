const passport = require('passport')
const passportJWT = require('passport-jwt')
const models = require("../models")
const User = models.user

const JWTStrategy = passportJWT.Strategy
const ExctractJWT = passportJWT.ExtractJwt


const verifyCallback = (payload, done) => {
  return User.findOne( {_id: payload.id }).then(user => {
    return done(null, user)
  }).catch(e => {
    return done(e)
  })
}

exports.passport = () => {
  const config = {
    jwtFromRequest: passportJWT.ExtractJwt.fromAuthHeaderAsBearerToken(),
    secretOrKey: process.env.JWT_SECRET
  }
  passport.use(User.createStrategy())
  passport.use(new JWTStrategy(config, verifyCallback))
}