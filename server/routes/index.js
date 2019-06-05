const express = require('express')
const router = express.Router()

router.get('/', function (req, res) {
  res.send('hello, express')
})
router.get('/:userId', function (req, res) {
  res.send('hello, '+req.params.userId)
})
module.exports = router
