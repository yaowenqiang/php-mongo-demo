<?php
require('dbconnection.php');
$mongo = DBConnection::instantiate();
$collection = $mongo->getCollection('sample_articles');
$key = array('author' => 1);
$keys = new MongoCode("function (article) {".
    "len = article.title.splie(' ').length;"
        ."if (len < 6 ) {".
            "return {hort:true};"
        ."} else if (6 <= len && len < 10>>) {".
            "return {medium:true};"
        ."} else return {large:true;}"
    );
//set both the aggregation counter ant total rating to zero
$initial = array('count'=>0,'total_rating'=>0);
//reduce function,increases counter by 1 and adds up the rating
$reduce = "function(obj,counter) { counter.count ++;".
        "counter.total_rating +=obj.rating;}";

$finalize = "function(counter) { counter.avg_rating = ".
        "Math.round(counter.total_rating/counter.count);}";
//quer condition,selects the documents created over last 24 hours for running the group()
$condition = array('publish_at'=>array('$gte'=> new MongoDate(strtotime('-1 day'))));
$result = $collection->group($key,
    $initial,
    new MongoCode($reduce),
    array(
        'finalize'=> new MongoCode($finalize),
        'condition'=>$condition
    )
);
?>

<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel='stylesheet' href='style.css'>
        <title>Author Rating</title>
    </head>
    <body>
        <div id='contentarea'>
            <div id='innercontentarea'>
                <h2>Author Rating</h2>
                 <table class='table-list' cellspacing='0' cellpadding='0'>
                     <thead>
                         <tr>
                             <th width='50%'>Author</th>
                             <th width='24%'>Articles</th>
                             <th width='*'>Average Rating</th>
                         </tr>
                     </thead>
                    <tbody>
                    <?php foreach($result['retval'] as $obj):?>
                        <tr>
                        <td><?php echo $obj['author'];?></td>
                        <td><?php echo $obj['count'];?></td>
                        <td><?php echo $obj['avg_rating'];?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                 </table>
            </div>
        </div>
    </body>
</html>

