const mysql = require('mysql')
const fs = require("fs")

class Database {
    constructor() {
        this.host = 'lo10-bfm.co016rps22pg.eu-west-3.rds.amazonaws.com'
        this.user = 'bfm'
        this.password = '12345678'
        this.database = 'lo10'
        this.port = 3306
        // Parameter for Idempotent Retry
        this.count = 0
    }
    //connect to the database
    connect() {
        this.connection = mysql.createConnection({
            host: this.host,
            user: this.user,
            password: this.password,
            database: this.database,
            port: this.port
        })
        this.connection.connect( (error) => {
            if (error) {
                console.error(this.count+error)
                this.count += 1
                if (this.count <= 3) {
                    setTimeout(() => {
                        this.connect()
                    }, 5000)
                }
            }
            else{
                this.count = 0
                console.info("Connected")
            } 
            
        })
        
    }

    /**
     *
     * Query of INSERT to stock information in the table
     * @param {String} table 
     * @param {JSON} post // The content of the information type JSON
     * @memberof Database
     */
    insert(table, post) {
        this.connection.query('INSERT INTO ' + table + ' SET ?', post, function (error, _results, _fields) {
            if (error) console.error(error)
        })
    }
    /**
     * Query of SELECT for searching information from the table
     * sql form like: 'where id=6;'
     * @param {String} table
     * @param {String} columns
     * @param {String} sql
     * @memberof Database
     */
    select(table, columns, sql, callback) {
        this.connection.query('SELECT ' + columns + ' FROM ' + table + " " + sql, function (error, results, _fields) {
            if (error) console.error(error)
            else {
                callback(results)
            }
        })
    }
    /**
     *  Update the table with new information
     * sql form like: " SET nom = 'Hill', email = 'mary.hill@yiibai.com' WHERE username = 'carrie1'; "
     * @param {String} table
     * @param {String} sql
     * @memberof Database
     */
    update(table, sql) {
        this.connection.query("UPDATE " + table + sql)
    }

    /**
     * Delete the lines that corresponds to sql
     * sql form like: 'where id=6;'
     * @param {*} table
     * @param {*} sql
     * @memberof Database
     */
    delete(table, sql) {
        this.connection.query("DELETE From" + table + sql)
    }

    //Disconnect
    disconnect() {
        this.connection.end(function (error) {
            if (error) console.error(error)
            else console.info("Disconnected")
        })
    }
}
module.exports = Database