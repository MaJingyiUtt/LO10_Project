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
      res.send({"nounouData": results[0]});
    })
    db.disconnect()
  
  })

  router.get('/', function (req, res) {
    const sql = "WHERE role='n'"
    db.connect()
    db.select(table,"*",sql,function (results){
      console.log(results);
      results.forEach(data => {
        data.photo = "https://lo10bfm.s3.amazonaws.com/" + data.photo
      });
      res.send({"nounouData": results});
    })
    db.disconnect()
  
  })
  module.exports = router;