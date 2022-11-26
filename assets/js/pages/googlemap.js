var map;
function initMap() {
    // Simple map
    map = new google.maps.Map(document.getElementById("map"), {
        center: {lat: 29.595670, lng: 52.576216},
        zoom: 6
    });


    // Map with marker
    var center = {lat: 35.698963, lng: 51.349121};

    var map = new google.maps.Map(document.getElementById("map-marker"), {
        scaleControl: true,
        center: center,
        zoom: 8
    });

    var infowindow = new google.maps.InfoWindow;
    infowindow.setContent("<p>&nbsp; &nbsp; ایران، تهران ...</p>");

    var marker = new google.maps.Marker({map: map, position: center});
    marker.addListener("click", function() {
        infowindow.open(map, marker);
    });
}