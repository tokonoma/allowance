<?php

include('system/config.php');
include('system/db_connect.php');

//routes for multiple pages
$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
switch ($request_uri[0]){
    // Home page
    case '/':
        require 'views/base.php';
        break;
    case '/cms':
        header("Location:/cms");
        exit();
        break;
    // Everything else
    default:
        header('HTTP/1.0 404 Not Found');
        require 'views/404.php';
        break;
}

//for testing
// if(!isset($_SESSION['user'])){
//     //no? do users even exist yet?
//     try{
//         $db = new PDO($dsn);
//         $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//         $numberofusers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
//         $db = NULL;
//     }
//     catch(PDOException $e){
//         $_SESSION['sessionalert'] = "loginfail";
//         header("Location: ".$baseurl);
//         exit();
//     }

//     if($numberofusers < 1){
//         include('cms/partials/startup.php');
//     }
//     else{
//         include('partials/auth.php');
//     }
// }