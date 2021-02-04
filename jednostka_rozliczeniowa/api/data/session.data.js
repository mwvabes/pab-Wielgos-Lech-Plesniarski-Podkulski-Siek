const fs = require('fs')
const sessionsConf = JSON.parse(fs.readFileSync('./conf/sessions_conf.json'))

const weekDayNaming = {
  0: "Sunday",
  1: "Monday",
  2: "Tuesday",
  3: "Wednesday",
  4: "Thursday",
  5: "Friday",
  6: "Saturday",
}

Date.prototype.addDays = function (days) {
  let date = new Date(this.valueOf())
  date.setDate(date.getDate() + days)
  return date;
}

exports.getCurrentSession = () => {
  const currentDate = new Date()
  const weekDay = currentDate.getDay()

  let currentSessionAvailable
  if (weekDay == 0) {
    currentSessionAvailable = currentDate.getFullYear() + "" + ("0" + ((currentDate.addDays(1)).getMonth() + 1)).slice(-2) + "" + ("0" + ((currentDate.addDays(1)).getDate())).slice(-2) + "_01"
  }
  else if (weekDay == 6) {
    currentSessionAvailable = currentDate.getFullYear() + "" + ("0" + ((currentDate.addDays(2)).getMonth() + 1)).slice(-2) + "" + ("0" + ((currentDate.addDays(2)).getDate())).slice(-2) + "_01"
  }
  else {
    let daysToAdd = 0
    let closestSession = sessionsConf.find(s => {
      return Date.parse(`01/01/1970/ ${s.hourClose}:00`) < Date.parse(`01/01/1970/ ${currentDate.getHours()}:${currentDate.getMinutes()}:00`)
    })
    if (closestSession == undefined) {
      closestSession = sessionsConf[0]
      daysToAdd = 1
    }
    currentSessionAvailable = currentDate.getFullYear() + "" + ("0" + (currentDate.getMonth() + 1)).slice(-2) + "" + ("0" + (currentDate.getDate() + daysToAdd)).slice(-2) + "" + closestSession.sessionName
  }

  return currentSessionAvailable

}

exports.lastlyServedSession = () => {
  const operatingDate = new Date()
  console.log("Operating", operatingDate, `01/01/1970/ ${sessionsConf[0].hourAnnounce}:00`)
  const weekDay = operatingDate.getDay()

  let lastlyServedSession = ""
  if (weekDay == 0) {
    operatingDate.setDate(operatingDate.getDate()-2)

    lastlyServedSession += operatingDate.getFullYear()

    lastlyServedSession += (operatingDate.getMonth() + 1) < 10 ? "0" + (operatingDate.getMonth() + 1) : (operatingDate.getMonth() + 1)
    lastlyServedSession += operatingDate.getDate() < 10 ? "0" + operatingDate.getDate()  : operatingDate.getDate()
    lastlyServedSession += sessionsConf[sessionsConf.length -1].sessionName

    return lastlyServedSession
  }
  else if (weekDay == 6) {
    operatingDate.setDate(operatingDate.getDate()-1)

    lastlyServedSession += operatingDate.getFullYear()

    lastlyServedSession += (operatingDate.getMonth() + 1) < 10 ? "0" + (operatingDate.getMonth() + 1) : (operatingDate.getMonth() + 1)
    lastlyServedSession += operatingDate.getDate() < 10 ? "0" + operatingDate.getDate()  : operatingDate.getDate()
    lastlyServedSession += sessionsConf[sessionsConf.length -1].sessionName

    return lastlyServedSession
  }
  else if (Date.parse(`01/01/1970/ ${sessionsConf[0].hourAnnounce}:00`) > Date.parse(`01/01/1970/ ${operatingDate.getHours()}:${operatingDate.getMinutes()}:00`)) {
    
    console.log("Sfind: Morning")

    if (weekDay == 1) {
      (operatingDate.setDate(operatingDate.getDate()-3))
    } else {
      (operatingDate.setDate(operatingDate.getDate()-1))
    }

    lastlyServedSession += operatingDate.getFullYear()

    lastlyServedSession += (operatingDate.getMonth() + 1) < 10 ? "0" + (operatingDate.getMonth() + 1) : (operatingDate.getMonth() + 1)
    lastlyServedSession += operatingDate.getDate() < 10 ? "0" + operatingDate.getDate()  : operatingDate.getDate()
    lastlyServedSession += sessionsConf[sessionsConf.length -1].sessionName

    return lastlyServedSession
  } else {
    let closestSession = [...sessionsConf].reverse().find(s => {
      console.log(Date.parse(`01/01/1970/ ${s.hourAnnounce}:00`).toLocaleString() + " " + Date.parse(`01/01/1970/ ${operatingDate.getHours()}:${operatingDate.getMinutes()}:00`))
      return Date.parse(`01/01/1970/ ${s.hourAnnounce}:00`) < Date.parse(`01/01/1970/ ${operatingDate.getHours()}:${operatingDate.getMinutes()}:00`)
    })

    console.log("closest", closestSession)

    lastlyServedSession += operatingDate.getFullYear()

    lastlyServedSession += (operatingDate.getMonth() + 1) < 10 ? "0" + (operatingDate.getMonth() + 1) : (operatingDate.getMonth() + 1)
    lastlyServedSession += operatingDate.getDate() < 10 ? "0" + operatingDate.getDate()  : operatingDate.getDate()
    lastlyServedSession += closestSession.sessionName

    console.log("lastly", lastlyServedSession)

    return lastlyServedSession

  }

}

exports.checkIfDone = (testedSession) => {

  const currentDate = new Date()
  const weekDay = currentDate.getDay()
  const month = currentDate.getMonth() + 1
  const year = currentDate.getFullYear()

  const tYear = testedSession.substring(0,4)
  const tMonth = testedSession.substring(4,6)
  const tDay = testedSession.substring(6,8)
  const tQueue = testedSession.substring(8,11)

  const tDate = new Date(`${tYear}-${tMonth}-${tDay}`)

  if (tDate == undefined) return false

  if (tDate < currentDate) {
    return true
  }
  else if (tDate == currentDate) {
    const s = sessionsConf.find(s => {
      return tQueue == s.sessionName
    })

    if (s == undefined) return false

  }
  else {
    return false
  }

  let currentSessionAvailable
  if (weekDay == 0) {
    currentSessionAvailable = currentDate.getFullYear() + "" + ("0" + ((currentDate.addDays(1)).getMonth() + 1)).slice(-2) + "" + ("0" + ((currentDate.addDays(1)).getDate())).slice(-2) + "_01"
  }
  else if (weekDay == 6) {
    currentSessionAvailable = currentDate.getFullYear() + "" + ("0" + ((currentDate.addDays(2)).getMonth() + 1)).slice(-2) + "" + ("0" + ((currentDate.addDays(2)).getDate())).slice(-2) + "_01"
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

  return currentSessionAvailable

}

exports.getCurrentlyServedSession = () => {
  const currentDate = new Date()
  const weekDay = currentDate.getDay()

  if (weekDay == 0) {
    return null
  }
  else if (weekDay == 6) {
    return null
  }
  else {

    let session = sessionsConf.find(s => Date.parse(`01/01/1970/ ${currentDate.getHours()}:${currentDate.getMinutes()}`) > Date.parse(`01/01/1970/ ${s.hourClose}`) && Date.parse(`01/01/1970/ ${currentDate.getHours()}:${currentDate.getMinutes()}`) < Date.parse(`01/01/1970/ ${s.hourAnnounce}`))
    
    if (session == undefined) return null

    return `${currentDate.getFullYear()}${currentDate.getMonth() + 1 < 10 ? "0" + (currentDate.getMonth() + 1) : (currentDate.getMonth() + 1) }${currentDate.getDate() < 10 ? "0" + currentDate.getDate() : currentDate.getDate()}${session.sessionName}`

  }

}

exports.getSchedule = () => {
  
  return sessionsConf

}