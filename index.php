<?php
try{
    $mongo = new Mongo();
    //$databases = $mongo->listDBs();
    $options = array('timeout'=>100);
    //$mongo = new Mongo($server='mongodb://localhost:8888');
    //$mongo = new Mongo($options);
    echo '<pre>';
    print_r($databases);
    $mongo->close();
    echo '</pre>';
} catch (MongoConnectionException $e) {
    die($e->getMessage());
}
