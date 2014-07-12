<?php
require 'dbconnection.php';
$id = $_GET['id'];
$mongo = DBConnection::instantiate();
$gridFS = $mongo->database->getGridFS();
//query the file object
$object = $gridFS->findOne(array('_id'=> new MongoId($id)));
//set content-type header,output in browser
header('Content-type:'.$object->file['filetype']);
echo $object->getBytes();
?>
