const express = require('express')
const router = express.Router()
const fs = require("fs")
const Database = require("../utils/database")

const db = new Database()
const table = "login"

//此处 根目录处于 /firstlogin/  详见 /server/index.js
//得到post请求后执行下列命令：1. 显示收到了 2.显示数据 3.返回一个JSON
// @todo 此处应连数据库 把数据存进去 然后开始执行verification
router.post('/', function (req, res) {
    console.info("request received")
    const data = req.body
    
    console.info(data)
    //connect to db and insert information
    db.connect()
    db.update(table,"SET message='Nous somme en train d'étudier votre profile modifié. Veuillez patienter. ',verified = false,nom='"+nom+"',prenom='"+prenom+"',adresse='"+adresse+"',ville='"+ville+"',email='"+email+"',portable='"+tel+"',sexe='"+sexe+"',token='"+token+"',photo='"+path+"', WHERE userId='"+userId+"'")
    db.disconnect()
    res.send({ "message": "post successfully" })
})

module.exports = router