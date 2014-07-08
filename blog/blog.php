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
                <div id="comment-section">
                    <?php if(!empty($article['comments'])):?>
                    <h1>Comments</h1>
                    <?php foreach ($article['comments'] as $comment) :
                        echo $comment['name'].' says ...';?>
                        <p><?php echo $comment['comment']; ?></p>
                    <span>
                        <?php echo date('g:i a: F j',$comment['posted_at']->sec); ?>
                    </span><br /><br /><br />
                    <?php endforeach;
                    endif;?>
                    <h3>Post your comment</h3>
                    <form action="comment.php" method='post'>
                        <span class="input-label">Name</span>
                        <input id="commenter_name" class='comment-input' type="text" name="commenter_name">
                        <br><br>
                        <span class="input-label">Email</span>
                        <input id="commenter_name" class='comment-input' type="text" name="commenter_email">
                        <br><br>
                        <textarea id="comment" name="comment"  rows="5"></textarea>
                        <br><br>
                        <input type="hidden" name="article_id" value='<?php echo $article['_id'];?>'>
                        <input  type='submit' name="btn_submit" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

