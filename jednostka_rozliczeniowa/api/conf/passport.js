const passport = require("passport");
const passportJWT = require("passport-jwt");
const LocalStrategy = require('passport-local').Strategy;
const JWTStrategy = passportJWT.Strategy;
const ExtractJWT = passportJWT.ExtractJwt;

const models = require("../models");
const User = models.user;


exports.passportInit = () => {
  passport.use(new LocalStrategy(User.authenticate()));
}
