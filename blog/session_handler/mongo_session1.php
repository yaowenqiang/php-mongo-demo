<?php
//Session started by requiring the script
require('session.php');
//Generate a random number
$random_number = rand();
//put the number into session
$_SESSION['random_number'] = $random_number;
?>
<!doctype html>
<html>
    <head>
        <title>Using the SessionManager ... Page 1</title>
    </head>
    <body>
        <div id='contentarea'>
            <div id='innercontentarea'>
                <h2>Using the SessionManager ... Page 1</h2>
                <p>Random number generated
                    <span style='font-weight:bold;'>
                        <?php echo $_SESSION['random_number'];?>
                    </span>
                </p>
                <p>PHP session id
                    <span style='text-decoration:underline;'>
                        <?php echo session_id();?>
                    </span>
                </p>
                <a href='mongo_session2.php'>Go to next page</a>
            </div>
        </div>
    </body>
</html>
