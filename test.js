const Database = require ("./server/utils/database")

var db = new Database()
db.select("login","*")