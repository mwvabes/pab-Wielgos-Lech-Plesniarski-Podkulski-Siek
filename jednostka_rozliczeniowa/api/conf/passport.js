const passport = require("passport");
const passportJWT = require("passport-jwt");
const LocalStrategy = passport.Strategy;
const JWTStrategy = passportJWT.Strategy;
const ExtractJWT = passportJWT.ExtractJwt;

const models = require("../models");
const User = models.user;


exports.passportInit = () => {
  const config = {
    jwtFromRequest: ExtractJWT.fromAuthHeaderAsBearerToken(),
    secretOrKey: process.env.JWT_SECRET,
  };
  passport.use('myLocalStrategy', new LocalStrategy(User.authenticate()));
  passport.use('myJwtStrategy', new JWTStrategy(config, function (payload, done){

    if (payload == undefined) {
      return done("Empty payload")
    }

    console.log("Payload", payload)

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
