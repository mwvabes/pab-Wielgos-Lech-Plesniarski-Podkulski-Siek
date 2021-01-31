const express = require('express')
const bodyParser = require("body-parser")
const { join } = require("path")
const axios = require("axios")
const cors = require('cors')
const swaggerJsDoc = require("swagger-jsdoc")
const swaggerUi = require("swagger-ui-express")
const YAML = require('yamljs')

const passport = require('./conf/passport')
passport.init()

const app = express()

app.use(cors())

const requestLogger = (request, response, next) => {
  const ip = request.headers['x-forwarded-for'] || request.connection.remoteAddress;
  console.log(`${ip} > ${request.method} ${request.path}`)
  console.log('Body:  ', request.body)
  console.log('Params:', request.params)
  console.log('---')
  next()
}



const swaggerDocument = YAML.load('./swagger.yaml');

app.use('/docs', swaggerUi.serve, swaggerUi.setup(swaggerDocument));

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
require("./routes/bank.route")(app)
require("./routes/auth.route")(app)
//app.use(unknownEndpoint)

app.get('/', (request, response) => {
  response.send(`Jednostka Rozliczeniowa - 1.0.1 >> ${new Date().toLocaleString()}`)
})

app.listen(process.env.PORT || 5000, () => {
  console.log(`Server started!`)
})
