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

function initForm(){
    document.getElementById("inputSurname").value=userFamilyName;
    document.getElementById("inputFirstname").value=userGivenName;
    document.getElementById("inputEmail").value=userEmail;
}

function imageAttention(){
    document.getElementById("attention").style.display = "block";
}

function noImageAttention(){
    document.getElementById("attention").style.display = "none";
    submitF();
}

function submitF(){
    console.log("submitForm");
    var form = document.getElementById("firstForm");
    var nom = form.inputSurname.value;
        console.log("nom = "+nom);
    var prenom = form.inputFirstname.value;
       console.log(prenom);
    var role = form.radiorole.value;
    console.log(role);
    var sexe = form.radiosexe.value;
    console.log(sexe);
    var email = form.inputEmail.value;
    console.log(email);
    var adresse = form.inputAddress.value;
     console.log(adresse);
    var tel = form.inputTelephone.value; 
    console.log(tel);
    var image = form.inputImage.value;
    console.log(image);
}