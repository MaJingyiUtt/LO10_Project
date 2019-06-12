var map, infowindow;
var isSubmitted = false;
var placeSearch;
var ville;
var marker, i;

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
  afficherContent();
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

function afficherContent(){
  document.getElementById("form1").style.display = "block";
}

function createMap() {
  geocoder = new google.maps.Geocoder();
  var options = {
    center: { lat: 48.297023, lng: 4.073805 },
    zoom: 10
  };
  map = new google.maps.Map(document.getElementById('map'), options);
  var input = document.getElementById('search');
  var searchBox = new google.maps.places.SearchBox(input);
  map.addListener('bounds_changed', function () {
    searchBox.setBounds(map.getBounds());
  });
  var markers = [];

  searchBox.addListener('places_changed', function () {
    var places = searchBox.getPlaces();

    if (places.length == 0)
      return;

    markers.forEach(function (m) { m.setMap(null); });
    markers = [];

    var bounds = new google.maps.LatLngBounds();

    places.forEach(function (p) {
      if (!p.geometry)
        return;
      markers.push(new google.maps.Marker({
        map: map,
        title: p.name,
        position: p.geometry.location,
        icon: {
          url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
        }
      }));
      placeSearch = p.geometry.location;
      var arrAddress = p.address_components;
      for (ac = 0; ac < arrAddress.length; ac++) {
        if (arrAddress[ac].types[0] == "locality") {
          ville = arrAddress[ac].long_name
        }
      }
      if (p.geometry.viewport)
        bounds.union(p.geometry.viewport);
      else
        bounds.extend(p.geometry.location);
    });
    map.fitBounds(bounds);
  });
}

function submitFormData() {
  var form = document.getElementById("form1");

  var sexe
  if (form.sexe.value == "Femme") {
    sexe = "f"
  }
  else if (form.sexe.value == "Homme"){
    sexe = "h"
  }
  else {
    sexe="tous"
  }

  var prix
  if (form.prix_max.value == "60+") {
    prix = 99999
  }
  else {
    prix = form.prix_max.value
  }

  if (!ville) {
    upper_ville = "TROYES"
  }
  else {
    upper_ville = ville.toUpperCase();
  }

  if (!form.content.value) {
    content = "*******"
  }
  else {
    content = form.content.value
  }
  document.getElementById('results').innerHTML = "";

  $.ajax({
    url: "http://18.222.63.99:3000/search/" + sexe + "/" + prix + "/" + content + "/" + upper_ville,
    header: "Access-Control-Allow-Origin: *",
    type: "GET",
    dataType: "json",
    success: function (data) {
      console.log(data.resultsData);
      if(data.resultsData.length==0){
        document.getElementById('results').innerHTML = "<div style='background-color:#eeeeee; padding:40px;margin-bottom:30px’><center><h3>Désolé, nous n'avons rien trouvé, veuillez réessayez.</h3></center></div>"
      }
      else{
        var results_address = [];
        for (i = 0; i < data.resultsData.length; i++) {
          results_address[i] = data.resultsData[i].adresse
        }
        for (i = 0; i < results_address.length; i++) {
          document.getElementById('results').innerHTML += "<div style='background-color:#eeeeee; padding:40px;margin-bottom:30px'><div class='row'><img class='col-sm-3' src='https://lo10bfm.s3.amazonaws.com/" +data.resultsData[i].photo+"'/><div class='col-sm-8'><h3>" + data.resultsData[i].nom + " " + data.resultsData[i].prenom + "</h3><div style='color: darkorange'><h4>" + data.resultsData[i].prix + " € / heure</h4></div><br/><div><b>Sexe:  </b>&nbsp&nbsp" + data.resultsData[i].sexe.toUpperCase() + "</div><div><b>Téléphone:  </b>&nbsp&nbsp" + data.resultsData[i].portable + "</div><div><b>Email:  </b>&nbsp&nbsp" + data.resultsData[i].email + "</div><div><b>Adresse:</b>&nbsp&nbsp" + data.resultsData[i].adresse + "</div><div><b>Description:  </b>&nbsp&nbsp" + data.resultsData[i].description + "</div></div></div></div>";
          currAddress = results_address[i];
          geocoder.geocode({ 'address': currAddress }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              marker = new google.maps.Marker({
                position: results[0].geometry.location,
                map: map,
                title: results[0].formatted_address
              });
              content = results[0].formatted_address;
              var infowindow = new google.maps.InfoWindow();
              google.maps.event.addListener(marker, 'click', (function (marker, content, infowindow) {
                return function () {
                  infowindow.setContent(content);
                  infowindow.open(map, marker);
                };
              })(marker, content, infowindow));
            }
          })
        };
    }
    }
  });
}

function subForm() {
  checkLogin();
  event.preventDefault(); 
  submitFormData();
}



