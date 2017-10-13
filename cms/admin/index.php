<?php

session_start();
include('../../system/config.php');
include('../../system/db_connect.php');

$baseurl  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$baseurl .= $_SERVER['SERVER_NAME'];
if (strpos($baseurl, 'localhost') !== false) {
    $baseurl .= ":".$_SERVER['SERVER_PORT'];
}
//$baseurl .= htmlspecialchars($_SERVER['REQUEST_URI']);
$cleanuri = explode('?', $_SERVER['REQUEST_URI'], 2);
$baseurl .= htmlspecialchars($cleanuri[0]);

//include alerts logic and messages
include('../../system/alerts.php');

//session expiration
if(isset($_SESSION['expire']) && time() > $_SESSION['expire']){
    session_unset();
    session_destroy();
    $statusMessage = "Your session has expired, please login again";
    $statusType = "danger";
}

//logout
if(isset($_GET['session']) && $_GET['session']=="logout"){ 
    session_unset();
    session_destroy();
    header("Location: "."../"."?alert=logout");
    exit();
}

//are you logged in?
if(!isset($_SESSION['user'])){
    // no - take back to main dir
    header("Location: "."../");
    exit();
}
else{
    //do you have access?
    if(!empty($_SESSION['adminacc'])){
        //yes - lets get you where you need to go
        $_SESSION['expire'] = time()+60*360; //reset session expire everytime the user users the site

        include('partials/admin.php');
    }
    else{
        header("Location: "."../?alert=admin");
    }
}