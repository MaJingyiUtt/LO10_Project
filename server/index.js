const express = require('express')
const app = express()
const indexRouter = require('./routes/index')
const firstloginRouter = require('./routes/firstlogin')

app.all('*', function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept, Authorization");
    next();
})


app.use('/', indexRouter)
app.use('/firstlogin', firstloginRouter)

app.listen(3000)
