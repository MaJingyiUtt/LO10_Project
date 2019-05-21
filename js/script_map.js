var map,infowindow;
var locations = [
  ['Julie', 48.269398, 4.066733, 1],
  ['Tom', 48.300058, 4.073061, 2]
];

var marker, i;
// var infowindow = new google.maps.InfoWindow({
//         content: "your"
//       });

function createMap () {
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

      

      if (p.geometry.viewport)
        bounds.union(p.geometry.viewport);
      else
        bounds.extend(p.geometry.location);
    });

    
    map.fitBounds(bounds);
  });
}  
