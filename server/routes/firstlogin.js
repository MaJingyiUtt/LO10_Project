const express = require('express')
const router = express.Router()

router.post('/', function(req, res){
    console.info("request received")
    console.log(req.body);
    res.send(" post successfully!");
})

module.exports = router