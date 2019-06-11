const express = require('express')
const router = express.Router()
const Database = require("../utils/database")
const detectFace = require("../utils/imageUtil")

const db = new Database()
const table = "detail"

router.get('/', function (req, res) {
  res.send('hello, express')
})
router.get('/userId/:userId', function (req, res) {

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
  

  let isVerified=true
  // req.params.token
  // req.params.id
  if(isVerified == false){
    // todo 
    db.update(table,"SET verified = '"+isVerified+"', WHERE userId='"+userId+"'")

  }else{
    const userId=  req.params.id
    const table = "login"
    const sql = " WHERE userId = '"+userId+"'"
    db.connect()
    //select the path of photo and send it to Rekognition for detectation
    db.select(table,"photo",sql,function (results){
      const path = results[0].photo
  
      //Send the photo to AWS.Rekogntion
      // Returns the Results and the reason if not succeeded,which is contained in the message
      detectFace(path, function (verified,message){
        db.connect()
        db.update(table," SET verified = '"+verified+"', message = '"+message+"' WHERE userId='"+userId+"'")
        db.disconnect()
        res.send({"verified": verified, "message": message})
      })
    })
    db.disconnect()
  }
 
})

module.exports = router
