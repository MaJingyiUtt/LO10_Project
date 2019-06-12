document.write("<script type='text/javascript' src='https://smtpjs.com/v3/smtp.js'></script>");
document.write("<script type='text/javascript' src='js/md5.js'></script>");
document.write("<script type='text/javascript' src='https://sdk.amazonaws.com/js/aws-sdk-2.471.0.min.js'></script>");

var userId;
var userName;
var userGivenName;
var userFamilyName;
var userEmail;

function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    userId = profile.getId();
    userName = profile.getName();
    userGivenName = profile.getGivenName();
    userFamilyName = profile.getFamilyName();
    userEmail = profile.getEmail();
    console.log(userId);
    initForm();
}

function logOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
    window.location.href = "index.html";
}

function checkLogin() {
    var b = true;
    if (!gapi.auth2.getAuthInstance().isSignedIn.get()) {
        alert("Veuillez connecter sur votre compte Google ! ");
        window.location.href = "index.html";
        b = false;
    }
    return b;
}

function initForm() {
    document.getElementById("inputSurname").value = userFamilyName;
    document.getElementById("inputFirstname").value = userGivenName;
    document.getElementById("inputEmail").value = userEmail;
}

function imageAttention() {
    document.getElementById("attention").style.display = "block";
}

function noImageAttention() {
    document.getElementById("attention").style.display = "none";

}

function showPreview(fileId, imgId) {
    var file = document.getElementById(fileId);
    var ua = navigator.userAgent.toLowerCase();
    var url = '';
    if (/msie/.test(ua)) {
        url = file.value;
    } else {
        url = window.URL.createObjectURL(file.files[0]);
    }
    document.getElementById(imgId).src = url;
}

/**
 * Click button "submit" and call this function 
 *
 */
function submitF() {
    document.getElementById("valider").style.display = "none";
    document.getElementById("load").style.display = "block";
    if (checkLogin()) {
        var form = document.getElementById("firstForm");
        var nom = form.inputSurname.value;
        var prenom = form.inputFirstname.value;
        var role = form.radiorole.value;
        var sexe = form.radiosexe.value;
        var email = form.inputEmail.value;
        var adresse = form.inputAddress.value;
        var ville = form.inputVille.value.toUpperCase();
        var tel = form.inputTelephone.value;
        var token = hex_md5(userId);
        var content = 'Bonjour, pour vérifier votre mail, veuillez cliquer ce lien : http://18.222.63.99:3000/verify/' + token + "/" + userId;
        var file = document.getElementById("firstForm").inputImage.files[0];

        //jQuery ajax
        // Parameters: 
        // url:http://18.222.63.99:3000/xxx 前边固定ip，斜杠后的东西需要对应express中的route
        // express部分 参考 ～/server/routes/firstlogin.js
        // header： 支持跨域 复制粘贴应该没错
        // type： POST/GET/PUT？
        // data：POST需要 应该必须是JSON格式，string可能也行没试过
        // dataType：这是设置返回数据类型的 假如express那边 res返回的是字符串 此处就是text；否则是JSON
        // 需要和express部分相吻合 否则无法执行 success这个回调函数（callback）
        // success：成功接收到res后执行的函数
        var name = file.name
        const path = name.replace(/[\w.]*\./,userId+".")
        var formData = {
            "userId": userId,
            "nom": nom,
            "prenom": prenom,
            "adresse": adresse,
            "ville":ville,
            "email": email,
            "portable": tel,
            "role": role,
            "sexe": sexe,
            "token": token,
            "photo": path
        }

        var file = document.getElementById("firstForm").inputImage.files[0];
        var credentials = {
            accessKeyId: accessKeyId,
            secretAccessKey: secreAccessKey
        };  //秘钥形式的登录上传
        AWS.config.update(credentials);
        AWS.config.region = 'us-east-1';   //设置区域
    
        // create bucket instance
        var bucket = new AWS.S3({ params: { Bucket: 'lo10bfm' } });  //选择桶
        if (file) {
            var params = { Key: path, ContentType: file.type, Body: file, 'Access-Control-Allow-Credentials': '*', 'ACL': 'public-read' }; //key可以设置为桶的相抵路径，Body为文件， ACL最好要设置
            bucket.upload(params, function (err, data) {
                if(err){
                    console.log(err);
                }else{
                    console.log("Upload succeeded!");
                    $.ajax({
                        url: "http://18.222.63.99:3000/firstlogin",
                        header: "Access-Control-Allow-Origin: *",
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        success: function (data) {
                            console.log("Response:" + data);
                            alert("Votre profile a bien été remis. Nous allons vous envoyer un mail  de vérification. Vous pouvez postuler une annonce après votre profile soit validé par notre système. ");
                            window.location.href = "user.html";
                        }
                    });
                }
            });
        } else {
            console.log('Nothing to upload.');
        }


      


        //



    }
}

