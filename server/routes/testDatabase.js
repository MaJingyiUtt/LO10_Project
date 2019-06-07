const Database = require("../utils/database")

const db = new Database()

const userId = "10574108257804770089"
const table = "login"
const sql = " WHERE userId = '" + userId + "'"
db.connect()
db.select(table, "*", sql, function (results) {
    console.log(results)
    results.forEach(row => {
        //
        console.info(JSON.stringify(row))
        
    
    })
})
db.disconnect()
