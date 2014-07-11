<?php
require('dbconnection.php');
$titles = array(
    'Nature always slides with the hidden flaw',
    'Adding manpower to a late software project makes it later.',
    'Research supports a specific theory depending on the amount of funds dedicated to it.',
    'Always draw your curves,thee plot your reading.',
    'Software bugs are hard to detect by anybody except may be the end user.',);
$authors = array("Luke Skywalker","Leia Organa",'Han Solo','Darth Vader','Spock','James Kirk','Hikaru Sulu','Nyota Uhura');
$description = 'Lorem ipsum dolor sit amet,consectetur adiipisicing elit,sed do eiusmod tempor incididunt ut labore et dolore agna aliqua.'.'Ut enim ad minim veniam,quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.';
$categories = array('Electronics','Mathematics','Programing','Data Structures','Algorithms','Computer Networking');
$tags = array('programming','testing','web design','tutorial','howto','version-control','nosql','algorithms','engineering','software','hardware','security');
function getRandomArrayItem($array)
{
    $length  = count($array);
    $randomIndex = mt_rand(0,$length-1);
    return $array[$randomIndex];
}
function getRandomTimestamp(){
    $randomDigit = mt_rand(0,6) * -1;
    return strtotime($randomDigit.' day');
}
function createDoc()
{
    global $titles,$authors,$categories,$tags;
    $title = getRandomArrayItem($titles);
    $author = getRandomArrayItem($authors);
    $category = getRandomArrayItem($categories);
    $articleTags = array();
    $numOfTags = rand(1,5);
    for ($j = 0; $j < $numOfTags; $j++) {
        $tag = getRandomArrayItem($tags);
        if (!in_array($tag,$articleTags)) {
            array_push($articleTags,$tag);
        }
    }
    $rating = mt_rand(1,10);
    $publishedAt = new MongoDate(getRandomTimestamp());
    return array(
        'title'=>$title,
        'author'=>$author,
        'category'=>$category,
        'tags'=>$articleTags,
        'rating'=>$rating,
        'publish_at'=>$publishedAt
    );
}
$mongo = DBConnection::instantiate();
$collection = $mongo->getCollection('sample_articles');
echo 'Generating sample data...<br/>';
for ($i = 0; $i < 1000; $i++) {
    $document = createDoc();
    $collection->insert($document);
}
echo 'Finished';
