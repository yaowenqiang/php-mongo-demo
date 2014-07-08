<?php
try {
    $connection = new MongoClient();
    $database = $connection->selectDB('myblogsite');
    $collection = $database->selectCollection('articles');
} catch (MongoConnectionException $e) {
}
$cursor = $collection->find();
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
                <?php while($cursor->hasNext()): $article = $cursor->getNext();?>
                <h2><?php echo $article['title'];?></h2>
                <p>
                    <?php echo substr($article['content'],0,200).'...';?>
                </p>
                <a href="blog.php?id=<?php echo $article['_id'];?>">Read More</a>
                <?php endwhile;?>
            </div>
        </div>
    </body>
</html>
