<style>
  #map {
    height: 100%;
  }
  #slider {
    width: 50%;
  }
</style>
	
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#slider" ).slider();
  });
</script>
  
<div class="mdl-grid demo-content">
    <div class="mdl-cell mdl-cell--12-col mdl-grid">
    	<div class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">



<!-- 	Lat: <input type="text" id="lat" value="49.25" /> -->
<!-- 	Lng: <input type="text" id="lng" value="-123.1" /> -->
	Radius: <div id="slider"></div> <input type="text" id="radius" value="0" /> m
    <div id="map"></div>


        </div>
    </div>
</div>


<script>
var citymap = {
  vancouver: {
    center: {lat: 49.25, lng: -123.1},
    population: 603502
  }
};

function initMap() {
  // Create the map.
  var cityCircle;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: {lat: 49.25, lng: -123.1},
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });
	
	// Place a draggable marker on the map
	var marker = new google.maps.Marker({
		position: {lat: 49.25, lng: -123.1},
		map: map,
		draggable:true,
		title: "Drag me!"
	});
	

	$('#slider').slider({
        slide: function(event, ui) {
			$("#radius").val(ui.value * 10000);
			drawCircle();
        }
    });
	
	marker.addListener('dragend', function() {
	   $("#lat").val(marker.getPosition().lat());
	   $("#lng").val(marker.getPosition().lng());
	   drawCircle();
	});
	
	function drawCircle() {
		if(cityCircle != undefined) {
		  cityCircle.setMap(null);
		}
		cityCircle = new google.maps.Circle({
		  strokeColor: '#BBD8E9',
		  strokeOpacity: 1,
		  strokeWeight: 3,
		  fillColor: '#BBD8E9',
		  fillOpacity: 0.6,
		  map: map,
		  center: {lat: marker.getPosition().lat(), lng: marker.getPosition().lng()},
		  radius: parseInt($("#radius").val())
		});
	}

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_maps_api_key')}}&signed_in=true&libraries=drawing&callback=initMap"
     async defer></script>
