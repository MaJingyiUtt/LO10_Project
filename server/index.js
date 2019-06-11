const bodyParser = require('body-parser')
const express = require('express')
const app = express()

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false }))

const indexRouter = require('./routes/index')
const firstloginRouter = require('./routes/firstlogin')
const postulerRouter = require('./routes/postuler')
const nounousRouter = require('./routes/nounous')
const searchRouter = require('./routes/search')

app.all('*', function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept, Authorization");
    next();
})


app.use('/', indexRouter)
app.use('/firstlogin', firstloginRouter)
app.use('/postuler', postulerRouter)
app.use('/nounous', nounousRouter)
app.use('/search', searchRouter)

app.listen(3000)