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

    <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('geofence_name')) is-invalid is-dirty @endif"" data-upgraded="eP">
    	{!!Form::text('geofence_name', $vehicle->geofence['notification']['text'], ['class' => 'mdl-textfield__input'])!!}
    	{!!Form::label('geofence_name', Lang::get('geofence.Name'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('geofence_name') }}</span>
    </div>     
    
    <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('geofence_radius')) is-invalid is-dirty @endif"" data-upgraded="eP">
 <!--     	<input id="radius" class="mdl-slider mdl-js-slider" type="range" id="s1" min="0" max="10000" value="0"> -->
	   	{!!Form::number('geofence_radius', $vehicle->geofence['radius'], ['id' => 'geofence_radius', 'class' => 'mdl-textfield__input'])!!}
    	{!!Form::label('geofence_radius', Lang::get('geofence.Radius'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('geofence_radius') }}</span>
    </div>  
 
	{!!Form::hidden('geofence_latitude', $vehicle->geofence['latitude'], ['id' => 'geofence_latitude'])!!}
	{!!Form::hidden('geofence_longitude', $vehicle->geofence['longitude'], ['id' => 'geofence_longitude'])!!}
    	   
    <div class="mdl-grid demo-content">
        <div class="mdl-cell mdl-cell--12-col mdl-grid">
        	<div class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
    
        	<div id="slider"></div>
            <div id="map"></div>
    
            </div>
        </div>
    </div>


<script>

function initMap() {
	@if(empty($vehicle->geofence['latitude']))
		var initialLat = 0;
	@else
		var initialLat = {{$vehicle->geofence['latitude']}};
	@endif
	
	@if(empty($vehicle->geofence['longitude']))
		var initialLng = 0;
	@else
		var initialLng = {{$vehicle->geofence['longitude']}};
	@endif

    var cityCircle;

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: {lat: initialLat, lng: initialLng},
        mapTypeId: google.maps.MapTypeId.TERRAIN
    });
	
	// Place a draggable marker on the map
	var marker = new google.maps.Marker({
		position: {lat: initialLat, lng: initialLng},
		map: map,
		draggable:true,
		title: "Drag me!"
	});

    if(navigator.geolocation && $('#geofence_latitude').val() == '') {
        browserSupportFlag = true;
        navigator.geolocation.getCurrentPosition(function(position) {
          initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
          map.setCenter(initialLocation);
          marker.setPosition(initialLocation);
          $("#geofence_latitude").val(position.coords.latitude);
          $("#geofence_longitude").val(position.coords.longitude);
        });
    }

	@if(!empty($vehicle->geofence['radius']))
		drawCircle();
	@endif

	$('#slider').slider({
        slide: function(event, ui) {
        	$("#geofence_radius").parent().addClass('is-dirty');
			$("#geofence_radius").val(ui.value * 1000);
			drawCircle();
        }
    });
	
	marker.addListener('dragend', function() {
	   $("#geofence_latitude").val(marker.getPosition().lat());
	   $("#geofence_longitude").val(marker.getPosition().lng());
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
		  radius: parseInt($("#geofence_radius").val())
		});
	}

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_maps_api_key')}}&signed_in=true&libraries=drawing&callback=initMap"
     async defer></script>

     
    <div class="mdl-card__actions">
    	<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
          {{ Lang::get('general.Send') }} 
        </button>
    </div>