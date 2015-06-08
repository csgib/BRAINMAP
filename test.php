<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">


    <style>
      html, body, #map-canvas {
        margin: 0;
        padding: 0;
        height: 100%;
	border: 1px solid #ff0000;
      }
    </style>


<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
</head>

<script type="text/javascript">

/* Déclaration des variables  */
var geocoder;
var map;
var markers = new Array();
var i = 0;
geocoder = new google.maps.Geocoder();

function initialize(lat,lng, loc) {


var paris = new google.maps.LatLng(lat, lng);
var myOptions = {
zoom: 16,
center: paris,
mapTypeId: google.maps.MapTypeId.HYBRID
}
map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
map.setCenter(loc);
var marker = new google.maps.Marker({
map: map,
position: loc
});
}

  function codeAddress() {
var address = "36000 Châteauroux";
geocoder.geocode( { 'address': address}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
initialize(results[0].geometry.location.lat(),results[0].geometry.location.lng(),results[0].geometry.location);
} else {
alert("Le geocodage n\'a pu etre effectue pour la raison suivante: " + status);
}
});
  }

</script>

  <body onload="codeAddress()">




<!DOCTYPE html>
<html>
  <head>

    <div id="map-canvas"></div>

  </body>
</html>

