const express = require('express')
const router = express.Router()
const fs = require("fs")
const Database = require("../utils/database")
const elasticemail = require('elasticemail')
const db = new Database()
const table = "login"

//此处 根目录处于 /firstlogin/  详见 /server/index.js
//得到post请求后执行下列命令：1. 显示收到了 2.显示数据 3.返回一个JSON
// @todo 此处应连数据库 把数据存进去 然后开始执行verification
router.post('/', function (req, res) {
    console.info("request received")
    const data = req.body

    var content = 'Bonjour, pour vérifier votre mail, veuillez cliquer ce lien : http://18.222.63.99:3000/verify/' + data.token + "/" + data.userId+" Le résultat sera affiché sur votre profile. "

    var client = elasticemail.createClient({
        username: 'ranfang19@gmail.com',
        apiKey: '7113902e-2358-48ee-874d-5c6991d9aa83'
      })
       
      var msg = {
        from: 'ranfang19@gmail.com',
        from_name: 'Nounous',
        to: data.email,
        subject: 'Nounous',
        body_text: content
      }
       
      client.mailer.send(msg, function(err, result) {
        if (err) {
          return console.error(err)
        }
       
        console.log(result)
    })
    
    console.info(data)
    //connect to db and insert information
    db.connect()
    db.update(table," SET message='Vous venez de modifier votre profil. ', verified = false, nom='"+data.nom+"', prenom='"+data.prenom+"', adresse='"+data.adresse+"', ville='"+data.ville+"', email='"+data.email+"', portable='"+data.portable+"', sexe='"+data.sexe+"', photo='"+data.photo+"' WHERE userId='"+data.userId+"'")
    
    db.disconnect()
    res.send({ "message": "post successfully" })
})

module.exports = router