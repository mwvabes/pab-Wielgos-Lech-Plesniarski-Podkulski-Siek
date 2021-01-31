const passport = require("passport");

const models = require("../models");
const User = models.user;


exports.passportInit = () => {
  passport.use(User.createStrategy());
}
