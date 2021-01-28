module.exports = (app) => {
  const router = require("express").Router()
  const authController = require("../controllers/auth.controller.js")

  router.post('/register', authController.register)

  app.use('/api/auth', router)

}
