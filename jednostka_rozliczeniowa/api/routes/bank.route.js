module.exports = (app) => {
  const router = require("express").Router()
  const numberController = require("../controllers/number.controller.js")

  router.get('/validate', numberController.validate)

  app.use('/api/number', router)

}
