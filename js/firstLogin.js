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
/**
 * Click button "submit" and call this function 
 *
 */
function submitF() {
    console.log("submitForm");
    var form = document.getElementById("firstForm");
    var nom = form.inputSurname.value;
    var prenom = form.inputFirstname.value;
    var role = form.radiorole.value;
    var sexe = form.radiosexe.value;
    var email = form.inputEmail.value;
    var adresse = form.inputAddress.value;
    var tel = form.inputTelephone.value;
    var image = form.inputImage.value;
    alert(nom + prenom + role + sexe + email + adresse + tel + image);

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
            "photo": image
        },
        dataType: "json",
        success: function (data) {
            console.log("Response:" + data);
        }
    });
}