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
    var id_token = googleUser.getAuthResponse().id_token;
    console.log("ID Token: " + id_token);
    changeStatus();
    user();
}
function logOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
    document.getElementById("signout").style.display = "none";
    document.getElementById("myCarousel").style.display = "block";
    document.getElementById("userAccount").style.display = "none";
    document.getElementById('username').innerText="LO10 projet";
}

function changeStatus() {
    document.getElementById("signout").style.display = "block";
    document.getElementById('username').innerText = userName;
}
function user() {
    document.getElementById("myCarousel").style.display = "none";
    document.getElementById("userAccount").style.display = "block";
    document.getElementById('profil').innerText=" Nom : "+userFamilyName+"   "+"   Prénom : "+userGivenName+"    "+"   Email : "+userEmail+"   ";
}
