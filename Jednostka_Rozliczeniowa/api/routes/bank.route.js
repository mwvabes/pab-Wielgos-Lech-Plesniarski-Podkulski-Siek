module.exports = (app) => {
  const router = require("express").Router()
  const bankController = require("../controllers/bank.controller.js")

  router.get('/', bankController.getConf)

  app.use('/api/bank', router)

}
