var map,infowindow;
var form = document.getElementById("form1");
var isSubmitted = false;

var locations;
var placeSearch;

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


function createMap () {
    geocoder = new google.maps.Geocoder();
    var options = {
      center: { lat: 48.297023, lng: 4.073805 },
      zoom: 10
    };
    map = new google.maps.Map(document.getElementById('map'), options);
    var input = document.getElementById('search');
    var searchBox = new google.maps.places.SearchBox(input);
    map.addListener('bounds_changed', function() {
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

    places.forEach(function(p) {
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
      if (p.geometry.viewport)
        bounds.union(p.geometry.viewport);
      else
        bounds.extend(p.geometry.location);
    }); 
      map.fitBounds(bounds);
    });
}

function submitFormData(){
  // var content = form.content.value;
  // var search = form.search.value;
  // var sexe = form.sexe.value;
  // var prix_max = form.prix_max.value;
    
    address = [
      ['Julie', "UTT, Troyes, France",1],
      ['Tom', "3 Rue Generale de gaulle,10000 Troyes,France",2]
    ];

    for (i = 0; i < address.length; i++) {
      currAddress = address[i][1];
      geocoder.geocode( { 'address': currAddress}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            title:results[0].formatted_address
          });
          content=results[0].formatted_address;
          var infowindow = new google.maps.InfoWindow();
          google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
            return function() {
              infowindow.setContent(content);
              infowindow.open(map,marker);
            };
        })(marker,content,infowindow)); 
        }
      })
    };
}

function subForm(){
  checkLogin();
  event.preventDefault();  // 取消按键的原始提交行为
  submitFormData();  //启动监听提交按钮
}



