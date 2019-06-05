const express = require('express')
const router = express.Router()
const Database = require("../utils/database")

const db = new Database()
const table = "detail"

router.get('/', function (req, res) {
  res.send('hello, express')
})
router.get('/:userId', function (req, res) {
  
  res.send({ "message": "get successfully" })
  console.log(req.params.userId)

  db.connect()

})
module.exports = router
