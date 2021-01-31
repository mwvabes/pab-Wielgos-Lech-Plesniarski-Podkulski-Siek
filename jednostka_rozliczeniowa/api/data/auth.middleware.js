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
    const token = request.headers.authorization;

    if (token) {
      jwt.verify(token, process.env.JWT_SECRET, (err, decodedToken) => {
        if (err) {
          response.send({message: "Nie udało się zautoryzować użytkownika", error: err.message});
        } else {
          console.log(decodedToken);
          request.user = decodedToken
          next();
        }
      });
    } else {
        console.log("Empty token")
        response.send({message: "Nie odnaleziono tokenu"});
    }
}