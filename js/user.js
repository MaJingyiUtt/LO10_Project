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

    // The ID token you need to pass to your backend:
    // var id_token = googleUser.getAuthResponse().id_token;
    //console.log("ID Token: " + id_token);
    monProfile();
}

function logOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
    window.location.href = "index.html";
}

function monProfile() {
    $.ajax({
        url: "http://18.222.63.99:3000/nounous/" + userId,
        header: "Access-Control-Allow-Origin: *",
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.nounouData);
            setUserProfile(data.nounouData)
        }
    });
    console.log(userId);  //key of BD
}

function setUserProfile(nounouData) {
    document.getElementById('image').src = "https://lo10bfm.s3.amazonaws.com/" + nounouData.photo;
    document.getElementById('nom').innerText = "Nom : " + nounouData.nom;
    document.getElementById('prenom').innerText = "Prénom : " + nounouData.prenom;
    document.getElementById('email').innerText = "Email : " + nounouData.email;
    if (nounouData.sexe == "f") {
        document.getElementById('sexe').innerText = "Sexe : " + "Femme";
    } else {
        document.getElementById('sexe').innerText = "Sexe : " + "Homme";
    }
    document.getElementById('adresse').innerText = "Adresse : " + nounouData.adresse;
    document.getElementById('portable').innerText = "Portable : " + nounouData.portable;
    document.getElementById('ville').innerText = "Ville : " + nounouData.ville;
    setMessage(nounouData);
}

function setMessage(nounouData) {
    if (nounouData.verified) {
        document.getElementById('message').innerText = "  Votre profile a été validé. Vous pouvez postuler. ";
    } else {
        document.getElementById('postuler').disabled = true;
        if (nounouData.message == null) {
            document.getElementById('message').innerText = "  Nous somme en train d'étudier votre profile. Veuillez patienter. ";
        } else {
            document.getElementById('message').innerText = "  "+nounouData.message;
        }
    }
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

function modifier() {
    document.getElementById("monProfile").style.display = "none";
    document.getElementById("modifierProfile").style.display = "block";

    $.ajax({
        url: "http://18.222.63.99:3000/nounous/" + userId,
        header: "Access-Control-Allow-Origin: *",
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.nounouData);
            setInputs(data.nounouData);
        }
    });
   // document.getElementById('inputnom').innerText = nounouData.nom;
}

function setInputs(nounouData){
    document.getElementById('inputnom').value = nounouData.nom;
    document.getElementById('inputprenom').value = nounouData.prenom;
    document.getElementById('inputemail').value = nounouData.email;
    if (nounouData.sexe == "f") {
        document.getElementById('radioFemme').checked=true;
    } else {
        document.getElementById('radioHomme').checked=true;
    }
    document.getElementById('inputadresse').value = nounouData.adresse;
    document.getElementById('inputportable').value = nounouData.portable;
    document.getElementById('inputville').value = nounouData.ville;
}



function enregisterP() {
    if (checkLogin()) {
        var nom = document.getElementById("inputnom").value;
        var prenom = document.getElementById("inputprenom").value;
        var sexe = document.getElementsByName("radiosexe").value;
        var email = document.getElementById("inputemail").value;
        var adresse = document.getElementById("inputadresse").value;
        var ville = document.getElementById("inputville").value.toUpperCase();
        var tel = document.getElementById("inputportable").value;
       // var token = hex_md5(userId);
        //var content = 'Bonjour, pour vérifier votre mail, veuillez cliquer ce lien : http://18.222.63.99:3000/verify/' + token + "/" + userId;
        var file = document.getElementById("inputImage").files[0];

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
            "sexe": sexe,
            "photo": path
        }

        var file = document.getElementById("inputImage").files[0];
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
                console.log("Upload succeeded!")
                $.ajax({
                    url: "http://18.222.63.99:3000/modifyProfil",
                    header: "Access-Control-Allow-Origin: *",
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    success: function (data) {
                        console.log("Response:" + data);
                        alert("Votre profile a bien été remis. Vous pouvez postuler une annonce après votre profile soit validé par notre système. ");
                        window.location.href = "user.html";
                    }
                });
            }
        });
    } else {
        console.log('Nothing to upload.');
    }
        
    }

    document.getElementById("monProfile").style.display = "block";
    document.getElementById("modifierProfile").style.display = "none";
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

function uploadToS3(photoName) {
    var file = document.getElementById("inputImage").files[0];
    var credentials = {
        accessKeyId: accessKeyId,
        secretAccessKey: secreAccessKey
    };  //秘钥形式的登录上传
    AWS.config.update(credentials);
    AWS.config.region = 'us-east-1';   //设置区域

    // create bucket instance
    var bucket = new AWS.S3({ params: { Bucket: 'lo10bfm' } });  //选择桶
    if (file) {
        var params = { Key: photoName, ContentType: file.type, Body: file, 'Access-Control-Allow-Credentials': '*', 'ACL': 'public-read' }; //key可以设置为桶的相抵路径，Body为文件， ACL最好要设置
        bucket.upload(params, function (err, data) {
            if(err){
                console.log(err);
            }else{
                console.log("Upload succeeded!")
            }
        });
    } else {
        console.log('Nothing to upload.');
    }
}