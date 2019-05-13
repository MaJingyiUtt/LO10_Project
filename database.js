const mysql = require('mysql')
const connection = () => mysql.createConnection({
    host: 'mysql-lo10.c8xnr1lyg1zz.us-east-2.rds.amazonaws.com',
    user: 'bfm',
    password: '12345678',
    database: 'new_schema',
    port: 3306
})

const post = { idnew_table: 1, text: 'Hello MySQL' }
const table = "new_table"
// connection.query('INSERT INTO '+table+' SET ?', post, function (error, results, fields) {
//   if (error) console.error(error)
// })
connection.query('SELECT * FROM new_table', function (error, results, fields) {
    console.log(results.toString())
    if (error) console.error(error)
})