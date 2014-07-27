var mapContainer = document.getElementById('map');
var map;

function init() {
    //Google map settings (map type,zzoom level etc.)
    var mapOptions = {
        zoom:15,
        disableDefaultUI:true,
        MapTypeId:google.maps.MapTypeId.ROADMAP
    };
    //draw the map inside the mapcontainer DOM
    map = new google.maps.Map(mapContainer,mapOptions);
    detectLocation();
}
function detectLocation() {
    var options = {
        enableHighAccuracy:true,
        maximumAge:1000,
        timeout:30000
    };
    //check if the browser supports geolocation
    if(window.navigator.geolocation) {
        //get current position
        window.navigator.geolocation.getCurrentPosition(
            markMyLocation,handleGeolocateError,
            options
        );
    } else {
        alert("Sorry,your browser doesn't seem to support geolocation :-(");
    }
}
function markMyLocation(position){
    //latitude,longitude of current location
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
    var msg = 'You are here';
    var pos = new google.maps.latLng(lat,lon);
    map.setCenter(pos);
    var infoBox = new google.maps.InfoWindow({
        map:map,
        position:pos,
        content:msg
    });
    //draw a Google Map Marker on current location
    var myMarker = new google.maps.Marker({
        map:map,
        position:pos
    });
    getNearByRestaurants(lat,lon);
    return;
}
function handleGeolocateError() {
    alert("Sorry,couldn't get your geolocation :-(");
}
function getNearByRestaurants(lat,lon) {
    //Send an Ajax request to get nearby restaurants
    $.ajax({
        url:'haystack.php?lat='+lat+'&lon='+lon,
        dataType:'json',
        'success':ajaxSuccess
    });
}
function ajaxSuccess(data){
    //callback function for Ajax,marks each nearby restaurant on Gogle map
    data.forEach(function(restaurant){
        var pos = new google.maps.Marker({map:map,position:pos});
        var marker = new google.maps.Marker({
            map:map,
            position:pos
        });
        var infoBox = new google.maps.InfoWindow({
            position:pos,
            content:restaurant.name
        });
    });
}
window.onload = init;
