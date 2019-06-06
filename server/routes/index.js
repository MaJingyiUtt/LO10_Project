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
  db.select(table,"*",sql,function (results){
    const isNew = results.length == 0
    console.log(isNew)
    res.send({"isNew": isNew})
  })
  db.disconnect()

})

router.get('/verify/:token/:id', function (req, res) {
  

  
  // req.params.token
  // req.params.id



})

module.exports = router
