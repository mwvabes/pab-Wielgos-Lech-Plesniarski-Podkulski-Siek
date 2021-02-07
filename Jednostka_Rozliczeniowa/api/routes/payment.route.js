module.exports = (app) => {
  const router = require("express").Router()
  const paymentController = require("../controllers/payment.controller.js")
  const jwtAuth = require('./../data/auth.middleware')

  router.get('/getIncoming', jwtAuth.auth, paymentController.getIncomingPayments)
  router.post('/', jwtAuth.auth, paymentController.addPaymentDisposition)
  router.post('/settle', jwtAuth.auth, paymentController.settlePaymentsHandler)
  router.post('/confirmation', jwtAuth.auth, paymentController.paymentConfirmation)
  router.get('/getCurrentlyServed', jwtAuth.auth, paymentController.getCurrentlyServedPayments)

  app.use('/api/payment', router)

}


