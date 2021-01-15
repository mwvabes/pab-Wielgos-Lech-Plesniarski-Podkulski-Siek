const express = require('express')
const bodyParser = require("body-parser")
const { join } = require("path")
const axios = require("axios")
const cors = require('cors')

const app = express()

app.use(cors())

const requestLogger = (request, response, next) => {
  console.log('Method:', request.method)
  console.log('Path:  ', request.path)
  console.log('Body:  ', request.body)
  console.log('Params:', request.params)
  console.log('---')
  next()
}

// const unknownEndpoint = (request, response) => {
//   response.status(404).send({ error: 'unknown endpoint' })
// }

app.use(express.json())
app.use(requestLogger)

app.use(bodyParser.urlencoded({extended: false}))
app.use(bodyParser.json())

require("./routes/number.route")(app)
require("./routes/payment.route")(app)
require("./routes/session.route")(app)
//app.use(unknownEndpoint)

app.get('/', (request, response) => {
  response.send('Jednostka Rozliczeniowa - 0.0.1')
})

const PORT = 3001
app.listen(process.env.PORT || 5000, () => {
  console.log(`Server running on port ${PORT}`)
})