const express = require('express')
const router = express.Router()

//此处 根目录处于 /firstlogin/  详见 /server/index.js
//得到post请求后执行下列命令：1. 显示收到了 2.显示数据 3.返回一个JSON
// @todo 此处应连数据库 把数据存进去 然后开始执行verification
router.post('/', function (req, res) {
    console.info("request received")
    console.info(req.body)

    res.send({ "message": "post successfully" })
})

module.exports = router