    <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('geofence_name')) is-invalid is-dirty @endif"" data-upgraded="eP">
    	{!!Form::text('geofence_name', $vehicle->geofence['notification']['text'], ['class' => 'mdl-textfield__input'])!!}
    	{!!Form::label('geofence_name', Lang::get('geofence.Name'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('geofence_name') }}</span>
    </div>     
    
    <div class="mdl-textfield mdl-js-textfield is-upgraded is-focused mdl-textfield--floating-label @if ($errors->has('geofence_radius')) is-invalid is-dirty @endif"" data-upgraded="eP">
	   	{!!Form::number('geofence_radius', $vehicle->geofence['radius'], ['id' => 'geofence_radius', 'class' => 'mdl-textfield__input'])!!}
		<input class="mdl-slider mdl-js-slider" type="range" id="geofence_slider" min="0" max="25000" value="0">
    	{!!Form::label('geofence_radius', Lang::get('geofence.Radius'), ['class' => 'mdl-color-text--primary-contrast mdl-textfield__label is-dirty'])!!}
    	<span class="mdl-textfield__error">{{ $errors->first('geofence_radius') }}</span>
    </div>  
 
	{!!Form::hidden('geofence_latitude', $vehicle->geofence['latitude'], ['id' => 'geofence_latitude'])!!}
	{!!Form::hidden('geofence_longitude', $vehicle->geofence['longitude'], ['id' => 'geofence_longitude'])!!}
    	   
    <div class="mdl-grid demo-content">
        <div class="mdl-cell mdl-cell--12-col mdl-grid">
        	<div class="mdl-data-table mdl-js-data-table mdl-cell--12-col mdl-shadow--2dp">
            	<div id="map"></div>
            </div>
        </div>
    </div>

    <div class="mdl-card__actions">
    	<button type="submit" class="mdl-button mdl-color--primary mdl-color-text--accent-contrast mdl-js-button mdl-button--raised mdl-button--colored">
          {{ Lang::get('general.Send') }} 
        </button>
    </div>
    
    
    
<script>

@if(!empty($vehicle->geofence['radius']))
$('#geofence_slider').val({{$vehicle->geofence['radius']}});
@endif

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
        zoom: 10,
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

	$('#geofence_slider').on('propertychange input', function (e) {
	    var valueChanged = false;

	    if (e.type=='propertychange') {
	        valueChanged = e.originalEvent.propertyName=='value';
	    } else {
	        valueChanged = true;
	    }
	    if (valueChanged) {
	    	$("#geofence_radius").parent().addClass('is-dirty');
			$("#geofence_radius").val($(this).val());
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

    