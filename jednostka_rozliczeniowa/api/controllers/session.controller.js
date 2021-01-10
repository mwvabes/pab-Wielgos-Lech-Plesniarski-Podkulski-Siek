const currentSessionAvailable = require('../data/session.data')

exports.getAvailableSession = (request, response) => {

  //console.log(currentSessionAvailable())

  response.json({
    currentSessionAvailable: currentSessionAvailable.getCurrentSession(),
  })

}

exports.checkIfDone = (request, response) => {

  response.json({
    isDone: currentSessionAvailable.checkIfDone(request.query.session),
  })

}

exports.getCurrentlyServedSession = (request, result) => {

  const session = sessionData.getCurrentlyServedSession()

  if (session == null) {
    result.status(400).json({
      session: null
    })
    return
  }

  result.status(200).json({
    session
  })

}