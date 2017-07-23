@extends('layout')

@section('title')
	About Us
@endsection

@section('content')
	<div class="container">
		<h2 class="text-center">72 Spring Street Danvers, Ma</h2>
		<div id="map" style="width: auto; height: 600px"></div>
		<hr>
		<h2 class="text-center">Directions</h2>
		<div id="panel"></div>
		<div id="right-panel"></div>
	</div>

	<script>
		var pos = {
			lat: 42.581948,
			lng: -70.952164
		};
		function initMap() {
			var map = new google.maps.Map(document.getElementById('map'), {
				center: pos,
				zoom: 12,
				mapTypeId: 'hybrid'
			});
			var infoWindow = new google.maps.InfoWindow({map: map});
			infoWindow.setPosition(pos);
			infoWindow.setContent("St. John's Prep");
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(map);

			if (navigator.geolocation) {
				directions(map);
			} else {
				alert("Location is turned off, please enable it to get directions");
			}
		}

		function directions(map) {
			var directionsService = new google.maps.DirectionsService;
			var directionsDisplay = new google.maps.DirectionsRenderer;
			directionsDisplay.setMap(map);
			calculateAndDisplayRoute(directionsService, directionsDisplay);
		}

		function calculateAndDisplayRoute(directionsService, directionsDisplay) {
			navigator.geolocation.getCurrentPosition(function (position) {
				user = {
					lat: position.coords.latitude,
					lng: position.coords.longitude
				};

				var go = new google.maps.LatLng(parseFloat(pos.lat), parseFloat(pos.lng));
				var from = new google.maps.LatLng(parseFloat(user.lat), parseFloat(user.lng));

				directionsService.route({
					origin: from,
					destination: go,
					travelMode: 'DRIVING'
				}, function (response, status) {
					if (status === 'OK') {
						directionsDisplay.setDirections(response);
						directionsDisplay.setPanel(document.getElementById('right-panel'));
					} else {
						window.alert('Directions request failed due to ' + status);
					}
				});
			});
		}

	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZtBXNincViepo2pAcXzYm6RIWtifymOo&callback=initMap"
	        async defer></script>
	<hr>

	<div class="container">Maps via <a href="https://developers.google.com/maps/documentation/javascript/">google maps
			javascript api</a></div>
@endsection