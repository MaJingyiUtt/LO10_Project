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
  console.log(req.params.userId)

  db.connect()

})

router.get('/verify/:token/:id', function (req, res) {
  

  
  // req.params.token
  // req.params.id



})

module.exports = router
