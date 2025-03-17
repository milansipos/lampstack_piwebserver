<?php
session_start();
$timeout = 900;

if(!isset($_SESSION['username'])) {
    header("Location:redirectlogin.php");
    exit();
}

if(isset($_SESSION['lastactivity'])) {
    $timeleft = time() - $_SESSION['lastactivity'];

    if($timeleft > $timeout) {
        session_unset();
        session_destroy();
        header("Location:redirectlogin.php");
        exit();
    }
}

$_SESSION['lastactivity'] = time();

?>