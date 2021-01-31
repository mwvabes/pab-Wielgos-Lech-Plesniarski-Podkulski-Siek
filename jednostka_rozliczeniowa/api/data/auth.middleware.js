const passport = require('passport')
const jwt = require('jsonwebtoken')


// exports.auth1 = (request, result, next) => {
//   return passport.authenticate('jwt', { session: false })(request, result, next)
// }

const models = require("../models")
const User = models.user

// exports.auth = (request, response, next) => {
//     return passport.authenticate('jwt', { session: false })(request, response, next)
// }

exports.auth = (request, response, next) => {
    const token = request.header.authentication;

    console.log("Req", request)

    // check json web token exists & is verified
    if (token) {
      jwt.verify(token, process.env.JWT_SECRET, (err, decodedToken) => {
        if (err) {
          console.log("Token verify error", err.message);
          response.redirect('/');
        } else {
          console.log(decodedToken);
          request.user = decodedToken
          next();
        }
      });
    } else {
        console.log("Empty token")
      response.redirect('/');
    }
}