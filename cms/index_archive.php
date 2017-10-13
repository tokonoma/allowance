<?php

session_start();
include('../system/config.php');
include('../system/db_connect.php');

$baseurl  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$baseurl .= $_SERVER['SERVER_NAME'];
if (strpos($baseurl, 'localhost') !== false) {
    $baseurl .= ":".$_SERVER['SERVER_PORT'];
}
//$baseurl .= htmlspecialchars($_SERVER['REQUEST_URI']);
$cleanuri = explode('?', $_SERVER['REQUEST_URI'], 2);
$baseurl .= htmlspecialchars($cleanuri[0]);

//include alerts logic and messages
include('../system/alerts.php');

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
    echo "hello cms";
    //header("Location: "."../");
    //exit();
}
else{
    //do you have access?
    if(!empty($_SESSION['cmsacc'])){
        //yes - lets get you where you need to go
        $_SESSION['expire'] = time()+60*360; //reset session expire everytime the user users the site
        //is mode = list or is nothing set at all? go to list view.
        if(isset($_GET['mode'])){
            $mode = $_GET['mode'];
            switch ($mode){
                case 'list':
                    if(isset($_GET['pid']) && !isset($_GET['sid'])){
                        include('partials/sections.php');
                    }
                    elseif(isset($_GET['pid']) && isset($_GET['sid'])){
                        include('partials/subsections.php');
                    }
                    else{
                        include('partials/pages.php');
                    }
                    break;
                case 'editor':
                    if(isset($_GET['uid'])){
                        $uid = $_GET['uid'];
                        $newbool = false;
                    }
                    elseif(isset($_GET['pid']) && isset($_GET['sid']) && !isset($_GET['uid'])){
                        $pid = $_GET['pid'];
                        $sid = $_GET['sid'];
                        $pageheader = "New Subsection";
                        $newbool = true;
                    }
                    else{
                        $_SESSION['sessionalert'] = "generalerror";
                        header("Location: ".$baseurl);
                        exit();
                    }
                    include('partials/editor.php');
                    break;
                case 'settings':
                    include('partials/user_settings.php');
                    break;
            }
        }
        elseif(isset($_GET['tab'])){
            if(!empty($_SESSION['adminacc'])){
                $tab = $_GET['tab'];
                switch ($tab){
                    case 'pages':
                        header("Location: ".$baseurl."?mode=list");
                        break;
                    case 'dashboard':
                        //
                        break;
                    case 'siteconfig':
                        //include('partials/[item].php');
                        break;
                    case 'useradmin':
                        include('partials/useradmin.php');
                        break;
                }
            }
            else{
                header("Location: ".$baseurl."?alert=admin");
            }
        }
        else{
            header("Location: ".$baseurl."?mode=list");
        }
    }
    else{
        header("Location: "."../?alert=cms");
    }
}