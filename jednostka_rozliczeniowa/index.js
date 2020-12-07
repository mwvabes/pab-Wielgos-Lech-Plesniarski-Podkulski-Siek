const express = require('express')
const validateNumber = require('./routes/validatenumber')

const app = express()

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
//app.use(unknownEndpoint)

app.get('/', (request, response) => {
  response.send('0.0.1')
})

app.get('/api/validatenumber', validateNumber.validateNumber) 

const PORT = 3001
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`)
})