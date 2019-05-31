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
}

function logOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
    window.location.href = "index.html";
}

function checkLogin(){
    var b=true;
    if(!gapi.auth2.getAuthInstance().isSignedIn.get()){
        alert("Veuillez connecter sur votre compte Google ! ");
        window.location.href = "index.html";
        b=false;
    }
    return b;
}

function postuler(){
    if(checkLogin()){
    var form = document.getElementById("form_postuler");
    var prix = form.prix.value;
    var description = form.description.value;
    console.log(prix);
    console.log(description);
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
        url: "http://18.222.63.99:3000/postuler",
        header: "Access-Control-Allow-Origin: *",
        type: "POST",
        data: {
            "userId": userId,
            "prix": prix,
            "description": description
        },
        dataType: "json",
        success: function (data) {
            console.log("Response:" + data);
        }
    });
    alert("Votre demande a bien été prise en compte.");
    window.location.href = "user.html";
}
}

function check_prix(){
    var form = document.getElementById("form_postuler");
    var reg=/^[1-9]\d*$|^0$/; // 注意：故意限制了 0321 这种格式，如不需要，直接reg=/^\d+$/;
    if(reg.test(form.prix.value)==true){
        document.getElementById("warning").innerText="";
        document.getElementById("submit").disabled=false;
    }
    else{
        document.getElementById("warning").innerText="Entrer un nombre s'il vous plaît.";
        document.getElementById("submit").disabled=true;
    }
}
