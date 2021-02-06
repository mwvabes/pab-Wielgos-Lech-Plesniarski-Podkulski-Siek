const validateNumber = require("../data/number.data")

exports.validate = (request, response) => {

  const v = validateNumber.validateNumber(request.query.accountnumber)

  response.status(v.status).json(v) 

}
