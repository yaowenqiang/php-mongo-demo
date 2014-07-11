<?php
require('dbconnection.php');
$mongo = DBConnection::instantiate();
//get an instance of MongodB object
$db = $mongo->database;
//define the map function
$map = new MongoCode("function() {".
    "for (i = 0;i < this.tags.length;i++) {".
        "emit(this.tags[i],1);".
    "}".
"}");
//define the reduce function
$reduce = new MongoCode("function(key,values){".
    "var count = 0;".
    "for(var i = 0;i<values.length;i++){".
        "count += values[i];".
    "}".
    "return count;".
"}");
//Run the map and reduce functions,store results in a collection
//named tagcount
$command = array(
    'mapreduce'=>'sample_articles',
    'map'=>$map,
    'reduce'=>$reduce,
    'out'=>'tagcount'
);
$db->command($command);
//load all the tags in an array,sorted by frequency
$tags = iterator_to_array($db->selectCollection('tagcount')->find()->sort(array('value'=>-1)));
//custom function for finding the tag with the highest frequency function
function getBiggestTag($tags){
    //reset the array to the first element;
    reset($tags);
    //get the first key of the associative array
    $firstKey = key($tags);
    //return the value of the first tag document
    return (int)$tags[$firstKey]['value'];
}
$biggestTag = getBiggestTag($tags);
//compare each tag with the biggest one and assign a weight
foreach ($tags as &$tag ) {
    $weight = floor(($tag['value']/$biggestTag) * 100);
    switch ($weight) {
        case ($weight < 10):
            $tag['class'] = 'class1';
            break;
        case (10 <= $weight && $weight < 20):
            $tag['class'] = 'class2';
            break;
        case (20 <= $weight && $weight < 30):
            $tag['class'] = 'class3';
            break;
        case (21 <= $weight && $weight < 40):
            $tag['class'] = 'class4';
            break;
        case (40 <= $weight && $weight < 50):
            $tag['class'] = 'class5';
            break;
        case (50 <= $weight && $weight < 60):
            $tag['class'] = 'class6';
            break;
        case (60 <= $weight && $weight < 70):
            $tag['class'] = 'class7';
            break;
        case (70 <= $weight && $weight < 80):
            $tag['class'] = 'class8';
            break;
        case (80 <= $weight && $weight < 90):
            $tag['class'] = 'class9';
            break;
        case ($weight >= 90):
            $tag['class'] = 'class10';
            break;
        default:
            $tag['class'] = 'class1';

            break;
    }

}
?>

<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel='stylesheet' href='style.css'>
        <title>Tag Cloud</title>
    </head>
    <body>
        <div id='contentarea'>
            <div id='innercontentarea'>
                <h2>Tag Cloud</h2>
                <ul id="tagcloud">
                    <?php foreach($tags as $tag):?>
                    <li>
                    <a href="#" class='<?php echo $tag['class'];?>'>
                        <?php echo $tag['_id']?>
                    </a>
                    </li>
                    <?php endforeach;?>
                </ul>
            </div>
        </div>
    </body>
</html>

