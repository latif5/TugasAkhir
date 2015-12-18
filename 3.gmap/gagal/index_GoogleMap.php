<?php

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-
strict.dtd">
<!--
Copyright 2008 Google Inc.
Licensed under the Apache License, Version 2.0:
http://www.apache.org/licenses/LICENSE-2.0
-->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<title>Google Maps AJAX + WebService Example - Data Jumlah Penduduk Per Propinsi di
Indonesia</title>
		<!-- Googgle Map API -->
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
		<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBM3jNhgHNYQmdv2DndQ540uZ1yg7_0_zc&sensor=false"></script>
		<script type="text/javascript">
		//<script src="http://maps.google.com/maps?file=api&v=2&key=AIzaSyBM3jNhgHNYQmdv2DndQ540uZ1yg7_0_zc" type="text/javascript" />
	//<script type="text/javascript">
	//<![CDATA[
	var map;
	var geocoder;
function load() {
if (GBrowserIsCompatible()) {
geocoder = new GClientGeocoder();
map = new GMap2(document.getElementById('map'));
map.addControl(new GSmallMapControl());
map.addControl(new GMapTypeControl());
map.setCenter(new GLatLng(-5.137623, 119.412460), 4);
}
}
function searchLocations() {
var address = document.getElementById('addressInput').value;
if (!address) {
searchLocationsNear('',0,10);
} else {
searchLocationsNear(address);
}
}
function searchLocationsNear(prop_name, page, page_size) {
var searchUrl = 'wsc_prop.php?prop_nama=' + prop_name;
if ((page) & (page_size)) {
searchUrl = 'wsc_prop.php?prop_nama=' + prop_name + '&page=' + page + '&page_size'
+page_size;
}
GDownloadUrl(searchUrl, function(data) {
var xml = GXml.parse(data);
var markers = xml.documentElement.getElementsByTagName('marker');
map.clearOverlays();
var sidebar = document.getElementById('sidebar');
sidebar.innerHTML = '';
if (markers.length == 0) {
sidebar.innerHTML = 'No results found.';
map.setCenter(new GLatLng(-5.137623, 119.412460), 4);
return;
}
var bounds = new GLatLngBounds();
for (var i = 0; i < markers.length; i++) {
var prop_nama = markers[i].getAttribute('prop_nama');
var prop_ibukota = markers[i].getAttribute('prop_ibukota');
var jml_penduduk = parseFloat(markers[i].getAttribute('prop_penduduk'));
var jml_penduduk_pria = parseFloat(markers[i].getAttribute('prop_penduduk_pria'));
var jml_penduduk_wanita = parseFloat(markers[i].getAttribute('prop_penduduk_wanita'));
var prop_website = markers[i].getAttribute('prop_website');
var point = new GLatLng(parseFloat(markers[i].getAttribute('lat')),
parseFloat(markers[i].getAttribute('lng')));
var marker = createMarker createMarker(point, prop_nama, prop_ibukota, jml_penduduk,
jml_penduduk_pria, jml_penduduk_wanita, prop_website);
map.addOverlay(marker);
var sidebarEntry = createSidebarEntry(marker, prop_nama, prop_ibukota, jml_penduduk,
jml_penduduk_pria, jml_penduduk_wanita, prop_website);
sidebar.appendChild(sidebarEntry);
bounds.extend(point);
}
map.setCenter(bounds.getCenter(), map.getBoundsZoomLevel(bounds));
});
}
function createMarker(point, prop_nama, prop_ibukota, jml_penduduk, jml_penduduk_pria,
jml_penduduk_wanita, prop_website) {
// Create our "tiny" marker icon
var iconBlue = new GIcon();
iconBlue.image = "http://labs.google.com/ridefinder/images/mm_20_blue.png";
iconBlue.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
iconBlue.iconSize = new GSize(24, 40);
iconBlue.shadowSize = new GSize(34, 40);
iconBlue.iconAnchor = new GPoint(6, 40);
iconBlue.infoWindowAnchor = new GPoint(5, 1);
var iconRed = new GIcon();
iconRed.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
iconRed.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
iconRed.iconSize = new GSize(12, 20);
iconRed.shadowSize = new GSize(22, 20);
iconRed.iconAnchor = new GPoint(6, 20);
iconRed.infoWindowAnchor = new GPoint(5, 1);

var markerOptions = {};
markerOptions.icon = G_DEFAULT_ICON;
if (jml_penduduk > 10000000 ){
markerOptions.icon = iconBlue;
}
markerOptions.title = prop_nama;
markerOptions.draggable = false;

var marker = new GMarker(point, markerOptions);
var html = 'Propinsi : <b>' + prop_nama + '</b> <br/>'
+ 'Ibukota : '+ prop_ibukota + '<br/><br/>'
+ '<table border=1> <thead> <th> Kriteria (Kelamin) </th> <th> Jumlah </th>
</thead>'
			+ '<tbody>'
+ '<tr> <td> Pria </td> <td aling="right">'+jml_penduduk_pria+'</td> </tr>'
+ '<tr> <td> Wanita </td> <td aling="right">'+jml_penduduk_wanita+'</td> </tr>'
+ '<tr> <td> Total </td> <td aling="right">'+jml_penduduk+'</td> </tr>'
+ '</tbody><table/>'
+ '<br/>'
+ 'WebSite : <a href="'+prop_website+'" target="_blank">'+prop_website+'</a>'
+ '<br/><br/>'
+ '<img src="">'
+ '<br/>'
+ 'Author : <a href="http://www.mhs.infoterkini.com"
target="_blank">www.mhs.infoterkini.com</a>';
GEvent.addListener(marker, 'click', function() {
marker.openInfoWindowHtml(html);
});
return marker;
}

function createSidebarEntry(marker, prop_nama, prop_ibukota, jml_penduduk, jml_penduduk_pria,
jml_penduduk_wanita, prop_website) {
var div = document.createElement('div');
var html = '<b>' + prop_nama + '</b> (' + jml_penduduk + ')<br/>' + prop_ibukota;
div.innerHTML = html;
div.style.cursor = 'pointer';
div.style.marginBottom = '5px';
GEvent.addDomListener(div, 'click', function() {
GEvent.trigger(marker, 'click');
});
GEvent.addDomListener(div, 'mouseover', function() {
div.style.backgroundColor = '#eee';
});
GEvent.addDomListener(div, 'mouseout', function() {
div.style.backgroundColor = '#fff';
});
return div;
}
//]]>
</script>
</head>
<body onload="load()" onunload="GUnload()">
<h2>Google Maps AJAX + WebService Example - Data Jumlah Penduduk Per Propinsi di
Indonesia</h2>
Propinsi: <input type="text" id="addressInput"/>
<br/>
<br/>
<div style="width:1000px; font-family:Arial,
sans-serif; font-size:11px; border:1px solid black">
<table>
<tbody>
<tr>
<td width="200" valign="top">
<div id="sidebar" style="overflow: auto; height: 500px; font-size: 11px; color:
#000"></div>
</td>
<td>
<div id="map" style="overflow: hidden; width:800px; height:500px">
</div>
<script type="text/javascript">
    var locations = [
      ['Bondi Beach', -33.890542, 151.274856, 4],
      ['Coogee Beach', -33.923036, 151.259052, 5],
      ['Cronulla Beach', -34.028249, 151.157507, 3],
      ['Manly Beach', -33.80010128657071, 151.28747820854187, 2],
      ['Maroubra Beach', -33.950198, 151.259302, 1]
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 10,
      center: new google.maps.LatLng(-33.92, 151.25),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) { 
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
  </script>
</td>
</tr>
</tbody>
</table>
</div>
</body>
</html>