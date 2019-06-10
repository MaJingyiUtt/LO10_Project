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
        url: "http://18.222.63.99:3000/nounous/"+userId,
        header: "Access-Control-Allow-Origin: *",
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log(data.nounouData);
            setUserProfile(data.nounouData)
            
        }
    });  
    console.log(userId);  //key of BD
    //  document.getElementById('sexe').innerText = ;   //TODO : get from BD or register for the first time
    //document.getElementById('adresse').innerText = ;
    //document.getElementById('ville').innerText = ;
}

function setUserProfile(nounouData){
    document.getElementById('image').src="https://lo10bfm.s3-us-east-1.amazonaws.com/"+nounouData.photo;
    document.getElementById('nom').innerText = nounouData.nom;
document.getElementById('prenom').innerText = nounouData.prenom;
document.getElementById('email').innerText = nounouData.email;
if(nounouData.sexe=="f"){
    document.getElementById('sexe').innerText = "Femme";
}else{
    document.getElementById('sexe').innerText = "Homme";
}
document.getElementById('adresse').innerText = nounouData.adresse;
document.getElementById('portable').innerText = nounouData.portable;
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
    document.getElementById('inputnom').innerText = nounouData.nom;
document.getElementById('inputprenom').innerText = nounouData.prenom;
document.getElementById('inputemail').innerText = nounouData.email;
document.getElementById('inputadresse').innerText = nounouData.adresse;
document.getElementById('inputportable').innerText = nounouData.portable;
}

function enregisterP() {
    document.getElementById("monProfile").style.display = "block";
    document.getElementById("modifierProfile").style.display = "none";
   // var inputsexe = document.getElementById("inputsexe").value;
   // var inputadresse = document.getElementById("inputadresse").value;
   // var inputville = document.getElementById("inputville").value;
    //console.log(inputsexe, inputadresse, inputville);
}