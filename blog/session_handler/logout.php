<?php
    require('session.php');
    require('user.php');
    $user = new User();
    $user->logout();
    header('location:login.php');
    exit;

