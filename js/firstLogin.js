document.write("<script type='text/javascript' src='https://smtpjs.com/v3/smtp.js'></script>");
document.write("<script type='text/javascript' src='md5.js'></script>");

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

function getPhoto() {
    //   https://blog.csdn.net/fd214333890/article/details/71250488
    var file = document.getElementById("firstForm").inputImage.files[0];
    //  var file = $("#imgForm").find("input")[0].files[0];
    //创建读取文件的对象
    var reader = new FileReader();
    //创建文件读取相关的变量
    var imgFile;
    //为文件读取成功设置事件
    reader.onload = function (e) {
        imgFile = e.target.result;
        console.log(imgFile);
        imgFile = imgFile.split(",")[1];   //去掉开头的data:image/jpeg;base64,
        return imgFile
    };
    //正式读取文件
    reader.readAsDataURL(file);
}


/**
 * Click button "submit" and call this function 
 *
 */
function submitF() {
    if (checkLogin()) {
        var form = document.getElementById("firstForm");
        var nom = form.inputSurname.value;
        var prenom = form.inputFirstname.value;
        var role = form.radiorole.value;
        var sexe = form.radiosexe.value;
        var email = form.inputEmail.value;
        var adresse = form.inputAddress.value;
        var tel = form.inputTelephone.value;
        var image = getPhoto();
        var token = hex_md5(userId);
        var content = 'Bonjour, pour vérifier votre mail, veuillez cliquer ce lien : http://18.222.63.99:3000/verify/' + token + "/" + userId;

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
        $.ajax({
            url: "http://18.222.63.99:3000/firstlogin",
            header: "Access-Control-Allow-Origin: *",
            type: "POST",
            data: {
                "userId": userId,
                "nom": nom,
                "prenom": prenom,
                "adresse": adresse,
                "email": email,
                "portable": tel,
                "role": role,
                "sexe": sexe,
                "photo": image,
                "token": token
            },
            dataType: "json",
            success: function (data) {
                console.log("Response:" + data);
                //send a email with a link
                Email.send({
                    Host: "smtp.elasticemail.com",
                    Username: "ranfang19@gmail.com",
                    Password: "7113902e-2358-48ee-874d-5c6991d9aa83",
                    To: email,
                    From: "ranfang19@gmail.com",
                    Subject: "Nounou",
                    Body: content
                }).then(
                    message => alert(message)
                );
                alert("Votre profile a bien été remis. Vous pouvez postuler une annonce après votre profile soit validé par notre système. ");
                window.location.href = "user.html";
            }
        });
    }}

