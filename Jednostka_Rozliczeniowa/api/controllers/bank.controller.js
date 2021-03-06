const fs = require('fs')
const sessionsConf = JSON.parse(fs.readFileSync('./conf/sessions_conf.json'))
const banksConf = JSON.parse(fs.readFileSync('./conf/banks_conf.json'))

const mongoose = require("mongoose")
const db = require('./../conf/dbconfig')

const models = require("../models")
const Bank = models.bank

mongoose.connect(db.url, db.attr)
Bank.find({}).then(p => {
  if (p == null || p.length === 0) {
    banksConf.filter(b => {
      const newBank = new Bank({
        bankID: b.bankID,
        bankName: b.bankName,
        bankBalance: 100000,
        bankUnits: b.bankUnits
      })
      newBank.save()
    })
  }
})



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

exports.getConf = (request, response) => {

  response.json({
    banks: banksConf
  })

}