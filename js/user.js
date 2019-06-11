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
    //  document.getElementById('sexe').innerText = ;   //TODO : get from BD or register for the first time
    //document.getElementById('adresse').innerText = ;
    //document.getElementById('ville').innerText = ;
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
        document.getElementById('postuler').style.display = "none";
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