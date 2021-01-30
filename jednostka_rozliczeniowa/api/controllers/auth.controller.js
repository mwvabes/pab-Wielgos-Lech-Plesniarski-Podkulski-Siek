const fs = require('fs')
const mongoose = require("mongoose")
const db = require('./../conf/dbconfig')

const models = require("../models")
const User = models.user

const jwt = require('jsonwebtoken')

exports.checkIfAdmin = (user) => {
  return `${user.type}` === "admin" ? true : false
}

exports.checkIfHasAccessToBank = (user, bank) => {

  if (`${user.type}` !== "bank") {
    return false
  }
  
  const found = user.bankIDs.find(u => {
    return `${u}` === `${bank}`
  })

  return found != undefined ? true : false
}

exports.login = (request, response) => {

  const token = jwt.sign({ id: request.user._id, type: request.user.type, bankIDs: request.user.bankIDs}, process.env.JWT_SECRET, { expiresIn: 1200 })

  return response.send({
    token
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

