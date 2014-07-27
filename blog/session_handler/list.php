<?php
require 'dbconnection.php';
$mongo = DBConnection::instantiate();
$gridFS = $mongo->database->getGridFS();
$objects = $gridFS->find();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uploaded Images</title>
<link rel="stylesheet" type='text/css'href="styles.css">
</head>
<body>
    <div id="contentarea">
        <div id="innercontentarea">
            <h1>Uploaded Images</h1>
            <table class='table-list' cellspacing='0' cellpadding='0'>
                <thead>
                    <tr>
                        <th width='40%'>Caption</th>
                        <th width='30%'>Filename</th>
                        <th width='*'>Size</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($object = $objects->getNext()): ?>
                    <tr>
                    <td><?php echo $object->file['caption'];?></td>
                    <td><a href='stream.php?id=<?php echo $object->file['_id']?>'><?php echo $object->file['filename'];?></a></td>
                    <td><?php echo ceil($object->file['length']/1024).' KB';?></td>
                    </tr>
                    <?php endwhile;?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
