const passport = require("passport");
const passportJWT = require("passport-jwt");
const JWTStrategy = passportJWT.Strategy;
const ExtractJWT = passportJWT.ExtractJwt;

const models = require("../models");
const User = models.user;

const verifyCallback = (payload, done) => {

  return User.findOne({ _id: payload.id })
    .then((user) => {
      console.log("pload", payload);
      return done(null, user);
    })
    .catch((e) => {
      return done(e);
    });
};

export default () => {
  const config = {
    jwtFromRequest: ExtractJWT.fromAuthHeaderAsBearerToken(),
    secretOrKey: process.env.JWT_SECRET,
  };
  passport.use(User.createStrategy());
  passport.use(new JWTStrategy(config, verifyCallback))
}
