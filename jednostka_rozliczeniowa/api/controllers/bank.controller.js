const fs = require('fs')
const sessionsConf = JSON.parse(fs.readFileSync('./conf/sessions_conf.json'))
const banksConf = JSON.parse(fs.readFileSync('./conf/banks_conf.json'))

exports.getAvailableSession = (request, response) => {

  const currentDate = new Date()
  const weekDay = currentDate.getDay();

  let currentSessionAvailable
    if (weekDay == 0) {
      currentSessionAvailable = currentDate.getFullYear() + "" + ("0" + ((date.addDays(1)).getMonth() + 1)).slice(-2) + "" + ("0" + ((date.addDays(1)).getDate())).slice(-2) + "_01"
    }
    else if (weekDay == 6) {
      currentSessionAvailable = currentDate.getFullYear() + "" + ("0" + ((date.addDays(2)).getMonth() + 1)).slice(-2) + "" + ("0" + ((date.addDays(2)).getDate())).slice(-2) + "_01"
    }
    else {
      let daysToAdd = 0
      let closestSession = sessionsConf.find(s => {
        return Date.parse(`01/01/1970/ ${s.hourClose}:00`) > Date.parse(`01/01/1970/ ${currentDate.getHours()}:${currentDate.getMinutes()}:00`)
      })
      if (closestSession == undefined) {
        closestSession = sessionsConf[0] 
        daysToAdd = 1
      }
      currentSessionAvailable = currentDate.getFullYear() + "" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "" + ("0" + (currentDate.getDate() + daysToAdd)).slice(-2) + "" + closestSession.sessionName
    }

  

  response.json({
    currentSessionAvailable,
  })

}

exports.getAvailableSession = (request, response) => {

  response.json({
    banks: banksConf
  })

}