module.exports = (app) => {
  const router = require("express").Router()
  const authController = require("../controllers/auth.controller.js")
  const passport = require("passport")

  router.post('/login', passport.authenticate('local', {session: false}), authController.login)
  router.post('/register', authController.register)

  app.use('/api/auth', router)

}
