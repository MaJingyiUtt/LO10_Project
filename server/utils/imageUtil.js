const AWS = require('aws-sdk')
const fs = require("fs")
const rekognition = new AWS.Rekognition({ region: 'us-east-1' })

const detectFace = function (path,callback){
    //Use S3 parameters
    const param = {
        "Image": {
            "S3Object": {
                "Bucket": "lo10bfm",
                "Name": path
            }
        }
    }
    rekognition.detectFaces(param, function (err, data) {
        if (err) {
            console.log(err)
        } else {
            var message
            const info = data.FaceDetails
            if(info.length != 1){
                message = "There is/are "+info.length+" person(s) in your photo"
                callback(false,message)
            }else if(info[0].BoundingBox.Width*info[0].BoundingBox.Height<0.1){
                message = "Your face is not big enough in the photo(>10%)"
                callback(false,message)
            }else if(info[0].Confidence<0.9){
                message = "Choose a photo which is clearer and brighter"
                callback(false,message)
            }else{
                callback(true,"Succeeded")
            }
        }
    })
}
module.exports = detectFace