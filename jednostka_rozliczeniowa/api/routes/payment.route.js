module.exports = (app) => {
  const router = require("express").Router()
  const paymentController = require("../controllers/payment.controller.js")

  router.get('/', paymentController.getIncomingPayments)
  router.post('/', paymentController.addPaymentDisposition)
  router.post('/settle', paymentController.settlePayments)
  router.get('/getCurrentlyServed', paymentController.getCurrentlyServedPayments)

  app.use('/api/payment', router)

}


