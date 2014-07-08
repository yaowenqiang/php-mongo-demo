<?php
$action = (!empty($_POST['btn_submit']) && ($_POST['btn_submit'] === 'Save')) ? 'save_article':'show_form';
switch ($action) {
case 'save_article':
    try{
    $connection = new MongoClient();
    $database = $connection->selectDB('myblogsite');
    $collection = $database->selectCollection('articles');
    $article = array(
        'title'=>$_POST['title'],
        'content'=>$_POST['content'],
        'saved_at'=>new MongoDate()
    );
    //$collection->insert($article);
    try {
        $status = $collection->insert(array(['title'=>'Blog Title','content'=>'Blog Content']),array('w'=>true));
        echo "Insert operation complete";
    } catch (MongoCursorException $e) {
        die('insert failed '.$e->getMessage());
    }
    try {
        $status = $collection->insert(array(['title'=>'Blog Title','content'=>'Blog Content']),array('w'=>true,'timeout'=>true));
        echo "Insert operation complete";
    } catch (MongoCursorTimeoutException $e) {
        die('insert failed '.$e->getMessage());
    }

} catch(MongoConnectionException $e) {
    die("Failed to connect to database ").$e->getMessage();
}
    break;
case 'show_form':
default:
    break;
}
?>
<!doctype html>
<html>
    <head>
        <title>Mongo blog</title>
        <link rel='stylesheet' href='style.css'>
    </head>
    <body>
        <div id='contentarea'>
            <div id='innercontentarea'>
                <h1>Blog Post Creator</h>
                <?php if($action === 'show_form'):?>
                    <form action='<?php echo $_SERVER['PHP_SELF'];?>' method='post'>
                        <h3>Title</h3>
                        <p>
                            <input type='text' name='title' id='title' />
                        </p>
                        <h3>Content</h3>
                        <textarea name='content' rows='20'></textarea>
                        <p>
                            <input type='submit' name='btn_submit' value='Save' />
                        </p>
                    </form>
                <?php else:?>
                    <p>
                        Article_saved:_id:<?php echo $article['_id'];?>.
                        <a href='blogpost.php'>
                            Write another one?
                        </a>
                    </p>
                <?php endif;?>
            </div>
        </div>
    </body>
</html>
