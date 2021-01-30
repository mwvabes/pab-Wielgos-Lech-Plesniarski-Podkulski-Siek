const passport = require('passport')


// exports.auth1 = (request, result, next) => {
//   return passport.authenticate('jwt', { session: false })(request, result, next)
// }

exports.auth = (request, response, next) => {
  passport.authenticate('jwt', { session: false, }, async (error, token) => {
      if (error || !token) {
          response.status(401).json({ message: 'Unauthorized' });
      } 
      try {
          const user = await User.findOne({
              where: { id: token.id },
          });
          request.user = user;
      } catch (error) {
          next(error);
      }
      next();
  })(request, response, next);   
}