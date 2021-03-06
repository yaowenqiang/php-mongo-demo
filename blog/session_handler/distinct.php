<?php
require('dbconnection.php');
$mongo = DBConnection::instantiate();
//get an instance of MongoDB object
$db = $mongo->database;
$collection = $mongo->getCollection('sample_articles');
$result = $db->command(array('distinct'=>'sample_articles','key'=>'category'));
//count example via php or mongo shell
$allRowNums = $collection->count();
//count with specified condition
//via mongo shell
//db.sample_articles.count();
$someRowNums = $collection->count(array('author'=>'Spock'));
//via mongo shell
//db.sample_articles.count({'author':'Spock'});

//mongo command line usage
//db.sample_articles.distinct('author')
?>

<!doctype html>
<html>
    <head>
        <title>Categoris</title>
    </head>
    <body>
        <div id='contentarea'>
            <div id='innercontentarea'>
                <h2>Distinct Categoris</h2>
                <ul>
                    <?php foreach($result['values'] as $value):?>
                    <li>
                    <?php echo  $value;?>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </body>
</html>

