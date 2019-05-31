const express = require('express')
const router = express.Router()

router.post('/', function(req, res){
    console.info("request received")
    console.info(req.body)
    
    res.send(" post successfully!")
    console.info(JSON.stringify(req.body))
})

module.exports = router