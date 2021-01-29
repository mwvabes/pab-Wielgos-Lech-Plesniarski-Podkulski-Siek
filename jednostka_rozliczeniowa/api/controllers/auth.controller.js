const fs = require('fs')
const mongoose = require("mongoose")
const db = require('./../conf/dbconfig')

const models = require("../models")
const User = models.user

exports.login = (request, response) => {
  return response.send({
    status: "success!"
  })
}


exports.register = (request, response) => {

  if (request.body.username == undefined
    || request.body.type == undefined
    || request.body.password == undefined) {

    response.status(400).json({
      message: "Niepoprawne parametry zapytania"
    })
    return
  }

  mongoose.connect(db.url, db.attr)

  let bankIDs;
  if (request.body.bankIDs == undefined) {
    bankIDs = []
  } else {
    bankIDs = request.body.bankIDs
  }

  const user = new User({
    username: request.body.username,
    type: request.body.type,
    bankIDs
  })

  User.register(user, request.body.password)



  response.json({
    message: `Użytkownik ${request.body.username} utworzony poprawnie`
  })

}

