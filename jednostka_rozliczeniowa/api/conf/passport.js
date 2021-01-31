const passport = require("passport");
const passportJWT = require("passport-jwt");
const JWTStrategy = passportJWT.Strategy;
const ExtractJWT = passportJWT.ExtractJwt;

const models = require("../models");
const User = models.user;


exports.passport = () => {
  const config = {
    jwtFromRequest: ExtractJWT.fromAuthHeaderAsBearerToken(),
    secretOrKey: process.env.JWT_SECRET,
  };
  passport.use('local', User.createStrategy());
  passport.use('jwt', new JWTStrategy(config, function (payload, done){

    User.findOne({ _id: payload.id })
      .then((user) => {
        console.log("pload", payload);
        return done(null, user);
      })
      .catch((e) => {
        return done(e);
      });
  }));
}
