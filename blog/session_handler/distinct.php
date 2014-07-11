<?php
require('dbconnection.php');
$mongo = DBConnection::instantiate();
//get an instance of MongoDB object
$db = $mongo->database;
$result = $db->command(array('distinct'=>'sample_articles','key'=>'category'));
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

