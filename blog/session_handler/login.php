<?php
$action = (!empty($_POST['login']) && ($_POST['login'] === 'Log in')) ? 'login' : 'show_form';
switch ($action) {
    case 'login':
        require('session.php');
        require('user.php');
        $user = new user();
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($user->authenticate($username,$password)) {
            header('location:profile.php');
            exit;
        } else {
            $errorMessage = 'username/password did not match.';
            break;
        }
    case 'show_form':
    default:
        $errorMessage = NULL;
        break;
}
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel='stylesheet' href='../style.css'>
        <title>User login</title>
    </head>
    <body>
        <div id='contentarea'>
            <div id='innercontentarea'>
                <h2>Log in here</h2>
                <div id="login-box">
                    <div class="inner">
                        <form id="login" action="login.php" method='post' accept-charset='utf-8'>
                            <ul>
                                <?php if(isset($errorMessage)):?>
                                <li><?php echo $errorMessage;?></li>
                                <?php endif?>
                                <li>
                                    <label>Username</label>
                                    <input class='textbox' tabindex='1' id="username" type="text" name="username" autocomplete='off'>
                                </li>
                                <li>
                                    <label for="password">Password</label>
                                    <input tabindex='2' id="password" type="password" name="password">
                                </li>
                                <li>
                                <input type="submit" value="Log in" id='login-submit' tabindex='3' name='login'>
                                </li>
                                <li class="clear"></li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

