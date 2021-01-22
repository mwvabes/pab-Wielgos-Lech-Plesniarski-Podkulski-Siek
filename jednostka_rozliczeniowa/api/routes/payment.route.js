module.exports = (app) => {
  const router = require("express").Router()
  const paymentController = require("../controllers/payment.controller.js")

  router.get('/getIncoming', paymentController.getIncomingPayments)
  router.post('/', paymentController.addPaymentDisposition)
  router.post('/settle', paymentController.settlePaymentsHandler)
  router.post('/confirmation', paymentController.paymentConfirmation)
  router.get('/getCurrentlyServed', paymentController.getCurrentlyServedPayments)

  app.use('/api/payment', router)

}


