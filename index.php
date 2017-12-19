<?php
date_default_timezone_set('America/New_York');
session_name('allowance');
session_start();

// Extend cookie life time by an amount of your liking
$cookieLifetime = 7 * 24 * 60 * 60; // A week in seconds
setcookie(session_name(),session_id(),time()+$cookieLifetime);

//system includes
include('system/config.php');
include('system/db_connect.php');

//looking for baseurl definition? it's in db_connect.php

//include alerts logic and messages
include('system/alert_msgs.php');

//actions
if(isset($_POST['action'])){ 
    $action = $_POST['action'];
    switch ($action){
        case 'login':
            if ((isset($_POST['email'])) && (isset($_POST['password']))){
                $input_email = $_POST['email'];
                $input_password = $_POST['password'];
                try{
                    $db = new PDO($dsn);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //very important email has single quotes
                    $users = $db->query("SELECT * FROM users WHERE email = '$input_email'");
                    $db = NULL;
                }
                catch(PDOException $e){
                    $_SESSION['sessionalert'] = "loginfail";
                    header("Location: ".$baseurl);
                    exit();
                }

                foreach($users as $user){
                    $email = $user['email'];
                    $password = $user['password'];
                    $firstname = $user['fname'];
                    $stayon = $user['stayloggedin'];
                }

                $checkpass = password_verify($input_password, $password);

                if(!empty($checkpass)){
                    $_SESSION['firstname'] = $firstname;
                    $_SESSION['email'] = $email;
                    $_SESSION['stayon'] = $stayon;

                    if($stayon == 0){
                        $_SESSION['expire'] = time()+60*360;
                    }
                    header("Location: ".$baseurl);
                    exit();
                }
                else{
                    $_SESSION['sessionalert'] = "loginfail";
                    header("Location: ".$baseurl);
                    exit();
                }
            }
            else{
                $_SESSION['sessionalert'] = "loginfail";
                header("Location: ".$baseurl);
                exit();
            }
            break;
        case 'logout':
            session_unset();
            session_destroy();
            header("Location: ".$baseurl."?alert=logout");
            exit();
            break;
        case 'save':
            //save procedure
            break;
        case 'createuser':
            //an attempt at added security admin user or first user
            if(!empty($_SESSION['admin']) || !empty($_SESSION['firstuser'])){
                include('system/createuser.php');
            }
            else{
                $_SESSION['sessionalert'] = "generalerror";
                header("Location: ".$baseurl);
                exit();
            }
            break;
    }
}

//session expiration
if(isset($_SESSION['expire']) && time() > $_SESSION['expire'] && $_SESSION['stayon'] == 0 ){
    session_unset();
    session_destroy();
    $statusMessage = "Your session has expired, please login again";
    $statusType = "danger";
}

//are you logged in?
if(!isset($_SESSION['email'])){
    //no? do users even exist yet?
    try{
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $numberofusers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $db = NULL;
    }
    catch(PDOException $e){
        //$_SESSION['sessionalert'] = "loginfail";
        //header("Location: ".$baseurl);
        echo $e;
        //exit();
    }

    if($numberofusers < 1){
        //first time
        $_SESSION['firstuser'] = true;
        include('views/startup.php');
    }
    else{
        include('views/auth.php');
    }
}
else{
    //yes - lets get you where you need to go
    $_SESSION['expire'] = time()+60*360; //reset session expire everytime the user uses the site
    //is mode = list or is nothing set at all? go to list view.
    if(isset($_GET['budget'])){
        include('views/budget_dashboard.php');
    }
    elseif(isset($_GET['mode'])){ 
        $mode = $_GET['mode'];
        switch ($mode){
            case 'settings':
                include('views/user_settings.php');
                break;
            case '404':
                include('views/404.php');
                break;
        }
    }
    elseif(isset($_GET['404'])){
        include('views/404.php');
    }
    else{
        include('views/budgets_dashboard.php');
    }
}