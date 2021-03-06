const passport = require("passport");
const passportJWT = require("passport-jwt");

const models = require("../models");
const User = models.user;

const LocalStrategy = require('passport-local').Strategy; 

exports.passportInit = () => {
  //passport.use(new LocalStrategy(User.authenticate()));
  //passport.use(User.createStrategy());
  passport.use(new LocalStrategy({
    session: false
  }, User.authenticate())); 
  // passport.use(new LocalStrategy({
  //   usernameField: username,
  //   passwordField: password,
  // }, async (username, password, done) => {
  //   try {
  //     const userDocument = await User.findOne({username: username}).exec();
  //     const passwordsMatch = await bcrypt.compare(password, userDocument.passwordHash);
  
  //     if (passwordsMatch) {
  //       return done(null, userDocument);
  //     } else {
  //       return done('Incorrect Username / Password');
  //     }
  //   } catch (error) {
  //     done(error);
  //   }
  // }));

}
