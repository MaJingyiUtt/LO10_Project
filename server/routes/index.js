const express = require('express')
const router = express.Router()
const Database = require("../utils/database")

const db = new Database()
const table = "detail"

router.get('/', function (req, res) {
  res.send('hello, express')
})
router.get('/userId/:userId', function (req, res) {
  
  res.send({ "message": "get successfully" })
  const userId = req.params.userId
  const table = "login"
  const sql = " WHERE userId = '"+userId+"'"
  db.connect()
  const results = db.select(table,"*",sql)
  db.disconnect()

  res.send({"new": results.length == 0})

})

router.get('/verify/:token/:id', function (req, res) {
  

  
  // req.params.token
  // req.params.id



})

module.exports = router
