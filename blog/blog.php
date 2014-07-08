<?php
$id = $_GET['id'];
try {
    $connection = new MongoClient();
    $database = $connection->selectDB('myblogsite');
    $collection = $database->selectCollection('articles');
} catch (MongoConnectionException  $e) {
    die('Failed to connect to database '.$e->getMessage());
}
$article = $collection->findOne(array('_id'=>new MongoId($id)));
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>My Blog Site</title>
        <link rel="stylesheet" href="style.css" title="" type="" />
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>My Blogs</h1>
                <h2><?php echo $article['title'];?></h2>
                <p>
                    <?php echo $article['content'];?>
                </p>
            </div>
        </div>
    </body>
</html>

