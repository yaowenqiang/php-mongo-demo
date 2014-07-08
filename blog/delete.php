<?php
$id = $_GET['id'];
try {
    $mongodb = new MongoClient();
    $articleCollection = $mongodb->myblogsite->articles;
} catch (MongoConnectionException $e) {
    die('Failed to connect to MongoDB '.$e->getMessage);
}
//$articleCollection->remove(array('_id'=> new MongoId($id)));
$articleCollection->remove(array('_id'=> new MongoId($id)),array('w'=>true,'socketTimeoutMS'=>200,'justOne'=>true));
?>

<!doctype html>
<html>
    <head>
        <title>Blog Post Creator</title>
        <link rel='stylesheet' href='style.css'>
    </head>
    <body>
        <div id="contentarea">
            <div id="innercontentarea">
                <h1>Blog Post Creator</h1>
                <p>
                    Article deleted: _id: <?php echo $id;?>
                    <a href='dashboard.php'>Go back to Dashboard?</a>
                </p>
            </div>
        </div>
    </body>
</html>
