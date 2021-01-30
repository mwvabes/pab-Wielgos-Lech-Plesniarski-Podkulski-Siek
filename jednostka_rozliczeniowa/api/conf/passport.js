const passport = require('passport')
const passportJWT = require('passport-jwt')
const models = require("../models")
const User = models.user

const JWTStrategy = passportJWT.Strategy
const ExtractJWT = passportJWT.ExtractJwt

const mongoose = require("mongoose")

const verifyCallback = (payload, done) => {
  mongoose.connect(db.url, db.attr)
  return User.findOne( {_id: payload.id }).then(user => {
    return done(null, user)
  }).catch(e => {
    return done(e)
  })
}

exports.passport = () => {
  const config = {
    jwtFromRequest: ExtractJWT.fromAuthHeaderAsBearerToken(),
    secretOrKey: process.env.JWT_SECRET
  }
  passport.use(User.createStrategy())
  passport.use(new JWTStrategy(config, verifyCallback))
}