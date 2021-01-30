const passport = require('passport')
const passportJWT = require('passport-jwt')
const JWTStrategy = passportJWT.Strategy
const ExtractJWT = passportJWT.ExtractJwt

const mongoose = require("mongoose")
const db = require('./../conf/dbconfig')

const models = require("../models")
const User = models.user

//mongoose.connect(db.url, db.attr)

const verifyCallback = (payload, done) => {

  //mongoose.connect(db.url, db.attr)

  User.find({ _id: payload.id }).then(user => {
    console.log("pload", payload)
    return done(null, user[0])
  }).catch(e => {
    return done(e)
  })
}

exports.passport = () => {
  //mongoose.connect(db.url, db.attr)
  console.log("Passport!")
  const config = {
    jwtFromRequest: ExtractJWT.fromAuthHeaderAsBearerToken(),
    secretOrKey: process.env.JWT_SECRET
  }
  passport.use(User.createStrategy())
  passport.use(new JWTStrategy(config, verifyCallback))
}