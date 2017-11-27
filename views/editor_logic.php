<?php

    try{
        //open/create the database sqlite
        //$db = new PDO('sqlite:data/content.sqlite');

        //postgres for prod
        $db = new PDO($dsn);
        //so it throws errors with messages
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //create a table - pgsl change - BIGSERIAL or SERIAL is needed for auto incrementing keys
        $db->exec("CREATE TABLE IF NOT EXISTS content (uid INTEGER PRIMARY KEY, pid INTEGER, sid INTEGER, pos INTEGER, title TEXT, body TEXT)");
        //$db->exec("CREATE TABLE IF NOT EXISTS content (uid BIGSERIAL PRIMARY KEY, pid INTEGER, sid INTEGER, pos INTEGER, title TEXT, body TEXT)");

        //saving
        if(isset($_POST['title-input']) && isset($_POST['body-input'])){
            $titleinput = $_POST['title-input'];
            $bodyinput = base64_encode($_POST['body-input']);

            // if its new
            if($newbool){
                //apparently other more normal-seeming function for row counting don't work in PDO?
                $numberofsubsections = $db->query("SELECT COUNT(*) FROM content WHERE sid = $sid")->fetchColumn(); 
                $newpos = $numberofsubsections+1;
                $insert = $db->prepare("INSERT INTO content (pid, sid, pos, title, body) VALUES (?, ?, ?, ?, ?)");
                $insertarray = array($pid, $sid, $newpos, $titleinput, $bodyinput);
                $insert->execute($insertarray);

                $uid = $db->lastInsertId();
                //this is changed from slite - pgsl requires [table]_[column]_seq as a parameter for calling lastInsertId
                //$uid = $db->lastInsertId(content_uid_seq);
            }
            // if we're editing
            else{
                $update = $db->prepare("UPDATE content SET title = :titleinput, body = :bodyinput WHERE uid = $uid");
                $update->bindParam(':titleinput', $titleinput, PDO::PARAM_STR);
                $update->bindParam(':bodyinput', $bodyinput, PDO::PARAM_STR);
                $update->execute();
            }

            $_SESSION['sessionalert'] = "pagesaved";

            header("Location: ".$baseurl."?mode=editor&uid=$uid");
            exit();
        }

        //populate content on page
        if($newbool){
            $title = "";
            $body = "";
            $pageheader = "New Subsection";
        }
        else{
            $result = $db->query("SELECT * FROM content WHERE uid = $uid");
            foreach($result as $row){
                $pid = $row['pid'];
                $sid = $row['sid'];
                $title = $row['title'];
                $body = base64_decode($row['body']);
            }
            $pageheader = "Edit Subsection";
        }

        //determine page header breadcrumb
        $thispg = $db->query("SELECT title FROM pages WHERE uid = $pid");
        foreach($thispg as $row){
            $thispgtitle = $row['title'];
        }

        $thissec = $db->query("SELECT title FROM sections WHERE uid = $sid");
        foreach($thissec as $row){
            $thissectitle = $row['title'];
        }

        // close the database connection
        $db = NULL;
    }
    catch(PDOException $e){
        $statusMessage = $e->getMessage();
        $statusType = "danger";
    }
?>