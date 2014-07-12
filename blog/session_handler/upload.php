<?php
require 'dbconnection.php';
$action = (isset($_POST['upload']) && $_POST['upload'] === 'Upload')?'upload':'view';
switch ($action) {
    case 'upload':
        //check file upload success
        if ($_FILES['image']['error'] !== 0) {
            die('Error uploading file,Error code '.$_FILES['image']['error']);
        }
        //connect to MongoDB server
        $mongo = DBConnection::instantiate();
        //get a MongoGridFS instance
        $gridFS = $mongo->database->getGridFS();
        $filename = $_FILES['image']['name'];
        $filetype = $_FILES['image']['type'];
        $tmpfilepath = $_FILES['image']['tmp_name'];
        $caption = $_POST['caption'];
        //storing the uploaded file
        $id = $gridFS->storeFile($tmpfilepath,array(
            'filetype'  => $filetype,
            'caption'  =>  $caption,
        ));
        break;
    default:
        break;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type='text/css' href="stye.css">
    <title>Upload Files</title>
</head>
<body>
    <div id="contentarea">
        <div id="innercontentarea">
            <h1>Upload Image</h1>
            <?php if($action === 'upload'):?>
            <h3>File Uploaded,Id <?php echo $id;?>
                <a href="<?php echo $_SERVER['PHP_SELF']?>">Upload another?</a>
            </h3>
            <?php else:?>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method='post'  accept-charset='utf-8' enctype='multipart/form-data'>
                <h3>Ente Caption&nbsp;
                    <input id="caption" type="text" name="caption">
                </h3>
                <p><input id="image" type="file" name="image"></p>
                <p><input type="submit" value="Upload" name='upload'></p>
            </form>
            <?php endif;?>
        </div>
    </div>
</body>
</html>
