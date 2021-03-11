@php
$config = [
    'appName' => config('app.name'),
    'locale' => $locale = app()->getLocale(),
    'locales' => config('app.locales'),
    'githubAuth' => config('services.github.client_id'),
];
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet" href="{{ mix('dist/css/app.css') }}">
</head>
<body>
  <div id="app"></div>

  {{-- Global configuration object --}}
  <script>
    window.config = @json($config);
  </script>

 
  
  <script src="{{ mix('dist/js/app.js') }}"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"
    integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

    <script async defer>
      // Initialize Google Map
      function initMap() {

// Default location
var defaultLoc = {lat: 53.3808279, lng: -1.4708821};

// Center map on default location
map = new google.maps.Map(document.getElementById('map'), {
  center: defaultLoc,
  zoom: 15
});

// Link search input to UI element.
var input = document.getElementById('search');
searchBox = new google.maps.places.SearchBox(input);
infowindow = new google.maps.InfoWindow();

// Bias the SearchBox results towards current map's viewport.
map.addListener('bounds_changed', function() {
  searchBox.setBounds(map.getBounds());
});

// Location entered into search box
var markers = [];
searchBox.addListener('places_changed', function() {

// Set global list
list = [];

// Get places
var places = searchBox.getPlaces();
if (places.length === 0) {
  return;
}

// Clear out old markers
markers.forEach(function(marker) {
  marker.setMap(null);
});
markers = [];

// For each place, get the icon, name and location.
var bounds = new google.maps.LatLngBounds();
places.forEach(function(place) {

  // Nothing found
  if (!place.geometry) {
    console.log("Returned place contains no geometry");
    return;
  }

  // Icon
  var icon = {
    url: place.icon,
    size: new google.maps.Size(71, 71),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(17, 34),
    scaledSize: new google.maps.Size(25, 25)
  };

  // Create a marker for each place.
  var marker = new google.maps.Marker({
    map: map,
    icon: icon,
    title: place.name,
    position: place.geometry.location
  });

  // Place details
  var request = { reference: place.reference };
  var details = new google.maps.places.PlacesService(map);
  details.getDetails(request, function(details, status) {

    // Add to object
    var obj = {
    "name": place.name,
    "address": place.formatted_address,
    "website": "",
    "phone_number": "",
    "emails": ""
    };
    // E-Mails
    var emails = '';
    if (details != null) {

      if (details.website != null) {
        var emailList = [];
        $.get("https://api.hunter.io/v2/domain-search?api_key="+hunter_key+"&domain="+details.website, function( data ) {
        $.each(data.data.emails, function(index, value) {
          emails += '<a href="mailto:'+value.value+'">'+value.value+'</a><br>';
          emailList.push(value.value);
        });
        });
        obj.website = details.website;
        obj.emails = emailList;
      }

      if (details.formatted_phone_number != null) {
        obj.phone_number = details.formatted_phone_number;
      }

    }
 
    // Push to master list
    list.push(obj);

    // If marker clicked
    google.maps.event.addListener(marker, 'click', function() {

      // Set info bubble
      infowindow.setContent('<div><h2>' + place.name + '</h2><br>' +
        '<span class="title">Address</span><br>' + place.formatted_address + '<br><br>' +
        (obj.phone_number === "" ? '' : '<span class="title">Phone Number</span><br>' + obj.phone_number + '<br><br>') +
        (obj.website === "" ? '' : '<span class="title">Website</span><br><a target="_blank" href="' + obj.website + '" title="'+ obj.website + '">'+ obj.website.substring(0,50) + '</a><br><br>') +
        (emails.length > 0 ? '<span class="title">E-Mail(s)</span><br>' + emails : '') +
        '</div>');
      infowindow.open(map, this);

    });

  });

  // Add to markers
  markers.push(marker);

  // Viewport
  if (place.geometry.viewport) {
    bounds.union(place.geometry.viewport);
  } else {
    bounds.extend(place.geometry.location);
  }

  });

  map.fitBounds(bounds);
});
}

    </script>
  {{-- <script src="{{ asset('dist/js/map.js') }}"></script> --}}
  <script defer async>
    // GOOGLE PLACES API KEY
    // Use the Google Developer Console to set up a key: https://console.developers.google.com/
    var google_key = "AIzaSyAD91gH-rDkHM9gL4Fh8FtaKYu47Mt7Igw";

    // HUNTER.IO API KEY
    // Get an API key here once you've signed up: https://hunter.io/api_keys
    // 0e6334f18497a873b578e401acdac1de68140882
    var hunter_key = "";

    (function (d, script) {
      script = d.createElement('script');
      script.type = 'text/javascript';
      script.async = true;
      script.defer = true;
      script.onload = function () {
        // remote script has loaded
      };
      script.src = 'https://maps.googleapis.com/maps/api/js?key=' + google_key + '&libraries=places&callback=initMap';
      d.getElementsByTagName('head')[0].appendChild(script);
    }(document));
  </script>
  

</body>
</html>
