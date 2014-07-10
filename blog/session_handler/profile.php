<?php
    require('session.php');
    require('user.php');
    $user = new User();
    if (!$user->isLoggedIn()) {
        header('location: login.php');
        exit;
    }
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel='stylesheet' href='../style.css'>
        <title>Welcom <?php echo $user->username;?></title>
    </head>
    <body>
        <div id='contentarea'>
            <div id='innercontentarea'>
                <a style='float:right;' href="logout.php">Log out</a>
                <h1>Log in here</h1>
                <ul class="profile-list">
                    <li>
                        <span class="field">Username</span>
                        <span class="value">
                            <?php echo $user->username;?>
                        </span>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <span class="field">Name</span>
                        <span class="value">
                            <?php echo $user->name;?>
                        </span>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <span class="field">Birthday</span>
                        <span class="value">
                            <?php echo date('j F, Y',$user->birthday);?>
                        </span>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <span class="field">Address</span>
                        <span class="value">
                            <?php echo $user->address;?>
                        </span>
                        <div class="clear"></div>
                    </li>
                </ul>
            </div>
        </div>
    </body>
</html>

