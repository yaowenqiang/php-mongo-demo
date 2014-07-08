<?php
/**
 * blog comment file
 *
 * @author yaowenqiang
 * @version $Id$
 * embed the comment object into the article is preferable to reference from an other collection  because embeddbed objects are more efficient in terms of performance,the documents share disk spaces,Also embedded documents are loaded to memory when you load their container documents,whereas to get a referenced document you have to hit the database again,So embedded documents tend to be a litter faster,But this doesn't mena you should always go for embedded objects!Wehen designing the data model,embedding should be the first choice,but if you see a reason that it should not be embedded ,you must reference it.
 * @copyright yaowenqiang, 09 July, 2014
 * @package default
 */
$id = $_POST['article_id'];
try {
    $mongodb = new MongoClient();
    $collection = $mongodb->myblogsite->articles;
} catch (MongoConnectionException $e) {
    die('Failed to connect to MongoDB '.$e->getMessage);
}
$article = $collection->findOne(array('_id'=> new MongoId($id)));
$comment = array(
        'name'=>$_POST['commenter_name'],
        'email'=>$_POST['commenter_email'],
        'comment'=>$_POST['comment'],
        'posted_at'=> new MongoDate()
    );
$collection->update(array('_id'=> new MongoId($id)),array('$push'=>array('comments'=>$comment)));
header('Location: blog.php?id='.$id);



