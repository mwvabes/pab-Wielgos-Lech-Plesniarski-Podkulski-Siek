const passport = require('passport')


// exports.auth1 = (request, result, next) => {
//   return passport.authenticate('jwt', { session: false })(request, result, next)
// }

const models = require("../models")
const User = models.user

exports.auth = (request, response, next) => {
  passport.authenticate('jwt', { session: false, }, async (error, token) => {
      if (error || !token) {
          response.status(401).json({ message: 'Unauthorized' });
      } 
      try {
          const user = await User.findOne({
              where: { _id: token.id },
          });
          request.user = user;
          next();
      } catch (error) {
          next(error);
      }
      
  })(request, response, next);   
}