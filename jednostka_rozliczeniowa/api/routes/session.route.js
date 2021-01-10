module.exports = (app) => {
  const router = require("express").Router()
  const sessionController = require("../controllers/session.controller.js")

  router.get('/', sessionController.getAvailableSession)
  router.get('/checkIfDone', sessionController.checkIfDone)
  router.get('/getCurrentlyServed', sessionController.getCurrentlyServedSession)

  app.use('/api/session', router)

}
