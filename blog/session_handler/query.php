<?php
$lat = (float)$_GET['lat'];
$lon = (float)$_GET['lon'];
$mongo = new MongoClient();
$collection = $mongo->selectDB('test')->selectCollection('restaurants');
//query the collection with given latitude and longitude
$query = array('location'=>array('$near'=>array($lat,$lon)));
$cursor = $collection->find($query);
$response = array();
while($doc = $cursor->getNext()){
    $obj = array(
        'name'=>$doc['name'],
        'serves'=>$doc['serves'],
        'latitude'=>$doc['location'][0],
        'longitude'=>$doc['location'][1]
    );
    array_push($response,$obj);
    //convert the array in JSON and send back to client
}
//within query
//$center = array(23.42342,90.23423);
//$radius = 10;
//$collection->find(array('location'=>array('$within'=>array('$center'=>array($center,$radius)))));
echo json_encode($response);
