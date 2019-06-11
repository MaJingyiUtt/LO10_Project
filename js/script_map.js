var map,infowindow;
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
      var arrAddress = p.address_components;
      for (ac = 0; ac < arrAddress.length; ac++) {
          if (arrAddress[ac].types[0] == "locality") 
          { 
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

function submitFormData(){
  var form = document.getElementById("form1");
  
  var sexe
  if (form.sexe.value=="Femme"){
    sexe="f"
  }
  else{
    sexe="h"
  }
  
  var prix 
  if (form.prix_max.value=="Prix max"){
    prix=99999
  }
  else{
    prix=form.prix_max.value
  }
  
  if(!ville){
    upper_ville="TROYES"
  }
  else{
    upper_ville = ville.toUpperCase();
  }

  if(!form.content.value){
    content="*******"
  }
  else{
    content=form.content.value
  }

  $.ajax({
    url: "http://18.222.63.99:3000/search/"+sexe+"/"+prix+"/"+content+"/"+upper_ville,
    header: "Access-Control-Allow-Origin: *",
    type: "GET",
    dataType: "json",
    success: function (data) {
        console.log(data.resultsData);
        // var results_adress=[];
        // for (i = 0; i < data.resultsData.length; i++){
        //   results_adress[i] = data.resultsData[i].adresse
        // }
        // console.log(results_adress)
        for (i = 0; i < data.resultsData.length; i++) {
          document.getElementById('results').innerHTML += "<div style='background-color:#eeeeee; padding:40px;margin-bottom:30px'><div><b>Nom:</b>"+data.resultsData[i].nom+"</div><div><b>Prenom:</b>"+data.resultsData[i].prenom+"</div><div><b>Adresse:</b>"+data.resultsData[i].adresse+"</div></div>";
          currAddress = data.resultsData[i].adresse;
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
});


    // address = [
    //   ['Julie', "UTT, Troyes, France",1],
    //   ['Tom', "3 Rue Generale de gaulle,10000 Troyes,France",2]
    // ];

}

function subForm(){
  checkLogin();
  event.preventDefault();  // 取消按键的原始提交行为
  submitFormData();  //启动监听提交按钮
}



