<?php

session_start();
include('system/config.php');
include('db_connect.php');

$baseurl  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$baseurl .= $_SERVER['SERVER_NAME'];
if (strpos($baseurl, 'localhost') !== false) {
    $baseurl .= ":".$_SERVER['SERVER_PORT'];
}
//$baseurl .= htmlspecialchars($_SERVER['REQUEST_URI']);
$cleanuri = explode('?', $_SERVER['REQUEST_URI'], 2);
$baseurl .= htmlspecialchars($cleanuri[0]);

//include alerts logic and messages
include('system/alerts.php');

//actions
if(isset($_POST['action'])){ 
    //$_SESSION['action'] = $_POST['action'];
    $action = $_POST['action'];
    switch ($action){
        case 'login':
            if ((isset($_POST['email'])) && (isset($_POST['password']))){
                //access user db
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
                    //echo $e->getMessage();
                    //$statusType = "danger";
                    $_SESSION['sessionalert'] = "loginfail";
                    header("Location: ".$baseurl);
                    exit();
                }

                foreach($users as $user){
                    $email = $user['email'];
                    $password = $user['password'];
                    $username = $user['fname'];
                    $cmsacc = $user['cms'];
                    $adminacc = $user['admin'];
                }

                $checkpass = password_verify($input_password, $password);

                if(!empty($checkpass)){
                    $_SESSION['user'] = true;
                    $_SESSION['ipauth'] = false;
                    $_SESSION['username'] = $username;
                    $_SESSION['user_id'] = $email;

                    $_SESSION['expire'] = time()+60*360;
                    if($cmsacc == true){
                        $_SESSION['cmsacc'] = true;
                    }
                    if($adminacc == true){
                        $_SESSION['adminacc'] = true;
                    }
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
    }
}

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
    header("Location: ".$baseurl."?alert=logout");
    exit();
}

//are you logged in?
if(!isset($_SESSION['user'])){
    //no? do users even exist yet?
    try{
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $numberofusers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $db = NULL;
    }
    catch(PDOException $e){
        $_SESSION['sessionalert'] = "loginfail";
        header("Location: ".$baseurl);
        exit();
    }

    if($numberofusers < 1){
        include('cms/partials/startup.php');
    }
    else{
        include('partials/auth.php');
    }
}
elseif(isset($_GET['session']) && $_GET['session']=="login"){
    include('partials/auth.php');
}
elseif(isset($_GET['mode']) && $_GET['mode']=="settings"){
    include('partials/user_settings.php');
}
else{
    //yes - lets get you where you need to go
    $_SESSION['expire'] = time()+60*360; //reset session expire everytime the user uses the site
    //is mode = list or is nothing set at all? go to list view.
    include('partials/catalog.php');
}