const Database = require ("./database")

var db = new Database()
db.select("login","*")