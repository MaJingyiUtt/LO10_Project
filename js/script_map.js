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
  if(!locations){
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

  else {
    var options = {
      center: placeSearch,
      zoom: 12
    };

    map = new google.maps.Map(document.getElementById('map'), options);
      place = new google.maps.Marker({
        position: placeSearch,
        map: map,
        icon: {
          url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
        }
      });

      for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map,
          title:locations[i][0]
        });
        content=locations[i][0];
        var infowindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
          return function() {
            infowindow.setContent(content);
            infowindow.open(map,marker);
          };
      })(marker,content,infowindow)); 
      }
  }
}

function submitFormData(){
  // var type = form.type.value;
  // var content = form.content.value;
  // var search = form.search.value;
  // var sexe = form.sexe.value;
  // var prix_min = form.prix_min.value;
  // var prix_max = form.prix_max.value;

  locations = [
    ['Julie', 48.269398, 4.066733, 1],
    ['Tom', 48.300058, 4.073061, 2]
  ];

}

function subForm(){
  checkLogin();
  event.preventDefault();  // 取消按键的原始提交行为
  submitFormData();  //启动监听提交按钮
  createMap();
}



