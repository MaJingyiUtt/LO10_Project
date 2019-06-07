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
            
        }
    });
    document.getElementById('nom').innerText = userFamilyName;
    document.getElementById('prenom').innerText = userGivenName;
    document.getElementById('email').innerText = userEmail;
    console.log(userId);  //key of BD
    //  document.getElementById('sexe').innerText = ;   //TODO : get from BD or register for the first time
    //document.getElementById('adresse').innerText = ;
    //document.getElementById('ville').innerText = ;
}

function modifier() {
    document.getElementById("monProfile").style.display = "none";
    document.getElementById("modifierProfile").style.display = "block";
    document.getElementById("inputnom").value = userFamilyName;
    document.getElementById("inputprenom").value = userGivenName;
    document.getElementById("inputemail").value = userEmail;
  //  document.getElementById("inputsexe").value = ;  //TODO : write value from BD if exists
//document.getElementById("inputadresse").value = ;
//document.getElementById("inputville").value = ;
}

function enregisterP() {
    document.getElementById("monProfile").style.display = "block";
    document.getElementById("modifierProfile").style.display = "none";
    var inputsexe = document.getElementById("inputsexe").value;
    var inputadresse = document.getElementById("inputadresse").value;
    var inputville = document.getElementById("inputville").value;
    console.log(inputsexe, inputadresse, inputville);
}