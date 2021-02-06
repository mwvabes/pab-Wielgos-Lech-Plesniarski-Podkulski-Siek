const sessionData = require('../data/session.data')

exports.getAvailableSession = (request, response) => {

  response.json({
    currentSessionAvailable: sessionData.getCurrentSession(),
  })

}

exports.checkIfDone = (request, response) => {

  response.json({
    isDone: sessionData.checkIfDone(request.query.session),
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

exports.getSchedule = (request, result) => {

  const schedule = sessionData.getSchedule()

  result.status(200).json({
    schedule
  })

}