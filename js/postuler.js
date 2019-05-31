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
    var form = document.getElementById("form_postuler");
    var prix = form.prix.value;
    var description = form.description.value;
    console.log(prix);
    console.log(description);
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
