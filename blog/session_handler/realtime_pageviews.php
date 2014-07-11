<?php

require('dbconnection.php');
$dbConnection = DBConnection::instantiate();
$collection = $dbConnection->getCollection('article_visit_counter_daily');
function getArticleTitle($id)
{
    global $dbConnection;
    $article = $dbConnection->getCollection('articles')->findOne(array('_id'=>new MongoId($id)));
    return $article['title'];
}
$objects = $collection->find(array('request_date'=>new MongoDate(strtotime('today'))));
?>


<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel='stylesheet' href='style.css'>
        <title>Daily page views(in realtime)</title>
    </head>
    <body>
        <div id='contentarea'>
            <div id='innercontentarea'>
                <h2>Daily page views(in realtime)</h2>
                 <table class='articles' cellspacing='0' cellpadding='0'>
                     <thead>
                         <tr>
                             <th>Article</th>
                             <th>Viewed</th>
                         </tr>
                     </thead>
                    <tbody>
                    <?php foreach($objects->sort(array('count'=>-1)) as $obj):?>
                        <tr>
                        <td><?php echo getArticleTitle((string)$obj['article_id']);?></td>
                        <td><?php echo $obj['count'];?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                 </table>
            </div>
        </div>
    </body>
<script type='text/javascript'>
    var REFRESH_PERIOD = 5000;//refresh every 5 seconds
    var t = setInterval('location.reload(true)',REFRESH_PERIOD);
</script>
</html>
