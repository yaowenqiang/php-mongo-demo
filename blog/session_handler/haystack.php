<?php
$lat = (float)$_GET['lat'];
$lon = (float)$_GET['lon'];
$mongo = new MongoClient();
$db = $mongo->selectDB('test');
//perform a search on the haystack index with the lat/long and where servers = Burger
$command = array(
    'geoSearch'=>'restaurants',
    'near'=>array($lat,$lon),
    'search'=>array('serves'=>'Burger'),
    'maxDistance'=>30
);
$response = $db->command($command);
$jsonResponse = array();
foreach ($response['results'] as $result) {
    $obj = array(
        'name'=>$result['name'],
        'serves'=>$result['serves'],
        'latitude'=>$result['location'][0],
        'longitude'=>$result['location'][1]
    );
    array_push($jsonResponse,$obj);
}
echo json_encode($jsonResponse);
