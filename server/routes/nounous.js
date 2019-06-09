const express = require('express')
const router = express.Router()
const Database = require("../utils/database")
const fs = require("fs")
const db = new Database()
const table = "login"

router.get('/:userId', function (req, res) {
    const userId = req.params.userId
    const sql = " WHERE userId = '"+userId+"'"
    db.connect()
    db.select(table,"*",sql,function (results){
      console.log(results[0]);

      const path = "/home/ubuntu/photos/"+results[0]+".jpg"
      fs.readFile(path, photo, (err) => {
        if (err) {
          console.error(err)
          
        }
      })
      res.send({"nounouData": results[0], });
    })
    db.disconnect()
  
  })
  module.exports = router;