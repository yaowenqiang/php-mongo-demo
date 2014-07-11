<?php
require('session_handler/dbconnection.php');
$mongo = DBConnection::instantiate();
$articles = $mongo->getCollection(('articles'));
$articleIds = array();
foreach ($articles->find(array(),array('_id'=>True)) as $article) {
    array_push($articleIds,(string)$article['_id']);
}
function getRandomArrayItem($array)
{
    $length = count($array);
    $randomIndex = mt_rand(0,$length - 1);
    return $array[$randomIndex];
}
echo 'Simulating blog post reading...';
$i = 100;
while ($i >0) {
    $id = getRandomArrayItem($articleIds);
    //change the value of$url accordingly on your machine
    $url = sprintf('http://192.168.1.107/blog.php?id=%s',$id);
    $curl_Handle = curl_init();
    curl_setopt($curl_Handle,CURLOPT_URL,$url);
    curl_setopt($curl_Handle,CURLOPT_HEADER,false);
    curl_setopt($curl_Handle,CURLOPT_RETURNTRANSFER,true);
    curl_exec($curl_Handle);
    curl_close($curl_Handle);
    $i --;
}
