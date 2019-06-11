const express = require('express')
const router = express.Router()
const Database = require("../utils/database")
const fs = require("fs")
const db = new Database()
const table = "detail d, login l"


router.get('/:sexe/:prix/:content/:ville', function (req, res) {
    const sexe = req.params.sexe //性别
    const prix = req.params.prix //最高价格
    const content = req.params.content //内容
    const ville = req.params.ville //位置
    const sql = "WHERE d.userId=l.userId and l.role='n' l.sexe = '"+sexe+"' and l.ville='"+ville+"' and l.verified='true' and d.prix<="+prix+" and d.description LIKE '%"+content+"%'"
    
    db.connect()
    db.select(table,"*",sql,function (results){
      console.log(results);
      res.send({"resultsData": results});
    })
    db.disconnect()
  
  })
  module.exports = router;