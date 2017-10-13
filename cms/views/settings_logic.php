<?php

try{
    //open/create the database sqlite
    //$db = new PDO('sqlite:data/content.sqlite');

    //postgres for prod
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = $_SESSION['user_id'];

    //if the form is submitted
    if(isset($_POST['user-email'])){

        //before doing anything, make sure nothing it blank
        $required = array('user-email', 'first-name', 'last-name');

        foreach($required as $field) {
            if (empty($_POST[$field])) {
                $_SESSION['sessionalert'] = "missingfield";
                header("Location: ".$_SERVER['REQUEST_URI']);
                exit();
            }
        }

        $input_email = $_POST['user-email'];
        $input_fname = $_POST['first-name'];
        $input_lname = $_POST['last-name'];

        $uniquecheck = $db->prepare("SELECT email from users where email = '$input_email'");
        $uniquecheck->execute();
        //echo $uniquecheck->rowCount();

        if(($input_email == $user_id) || ($uniquecheck->rowCount() <= 0)){

            //did they try to change their password
            if(!empty($_POST['password-one']) || !empty($_POST['password-two'])){

                //are both fields entered and are they the same?
                if(!empty($_POST['password-one']) && !empty($_POST['password-two']) && $_POST['password-one'] == $_POST['password-two'] ){
                    //save it
                    $input_pass = $_POST['password-one'];
                    $newpass = password_hash($input_pass, PASSWORD_BCRYPT);
                    $update = $db->prepare("UPDATE users SET password = :newpass WHERE email = '$user_id'");
                    $update->bindParam(':newpass', $newpass, PDO::PARAM_STR);
                    $update->execute();

                    $_SESSION['sessionalert'] = "passwordchanged";
                }
                else{
                    $_SESSION['sessionalert'] = "passwordchangefail";
                    header("Location: ".$_SERVER['REQUEST_URI']);
                    exit();
                }

            }
            else{
                $_SESSION['sessionalert'] = "settingssaved";
            }

            //if the email is the same or it's new AND unique, go ahead and save it
            $update = $db->prepare("UPDATE users SET email = :email, fname = :fname, lname = :lname WHERE email = '$user_id'");
            $update->bindParam(':email', $input_email, PDO::PARAM_STR);
            $update->bindParam(':fname', $_POST['first-name'], PDO::PARAM_STR);
            $update->bindParam(':lname', $_POST['last-name'], PDO::PARAM_STR);
            $update->execute();

            $_SESSION['username'] = $input_fname;
            $_SESSION['user_id'] = $input_email;
            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();
        }
        else{
            //not unique, throw error
            $_SESSION['sessionalert'] = "emailexists";
            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();
        }

    }

    //populate content on page
    $results = $db->query("SELECT * FROM users WHERE email = '$user_id'");

    // close the database connection
    $db = NULL;
}
catch(PDOException $e){
    $statusMessage = $e->getMessage();
    $statusType = "danger";
}


?>