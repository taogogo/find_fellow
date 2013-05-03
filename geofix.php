<?php
$longitude = floatval($_GET['longitude']);

$latitude = floatval($_GET['latitude']);
$markers = $_GET['markers'];
$markerStyles = $_GET['markerStyles'];
$labels = $_GET['labels'];
$labelStyles = $_GET['labelStyles'];
$content = '';
$url = "http://api.weibo.com/2/location/geo/gps_to_offset.json?source=2172534488&coordinate={$longitude},{$latitude}";

 $f = new SaeFetchurl();
  $content = json_decode( $f->fetch( $url ) , true);

if( empty( $content ) )
{
	$content['geos'][0]['longitude'] = $longitude;
        $content['geos'][0]['latitude'] = $latitude;
}
header("location:http://api.map.baidu.com/staticimage?labels={$labels}&labelStyles={$labelStyles}&markers={$markers}&markerStyles={$markerStyles}&width=400&height=400&center={$content['geos'][0]['longitude']},{$content['geos'][0]['latitude']}&zoom=14");