<?php

    $dashboarduser = $_SESSION['email'];
    
   try{
        //postgres for prod
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        //new or edited item save
        /*
        if(isset($_POST['item-title-input']) && isset($_POST['item-desc-input'])){
                
            $itemtitle = $_POST['item-title-input'];
            $itemdesc = $_POST['item-desc-input'];
            $newitempos = $_POST['new-item-pos'];
            $edituid = $_POST['edit-item-uid'];

            // if new pos has value and edit uid is empty, add a NEW item to the db
            if(!empty($newitempos) && empty($edituid)){
                $insert = $db->prepare("INSERT INTO $insertprep");
                array_push($insertarray, $newitempos, $itemtitle, $itemdesc);
                $insert->execute($insertarray);
                $_SESSION['sessionalert'] = "itemcreated";
            }
            // if new pos is empty and edit uid has a value, UPDATE the item based on its UID
            elseif(!empty($edituid) && empty($newitempos)){
                $update = $db->prepare("UPDATE $dbtable SET title = :itemtitle, description = :itemdesc WHERE uid = $edituid");
                $update->bindParam(':itemtitle', $itemtitle, PDO::PARAM_STR);
                $update->bindParam(':itemdesc', $itemdesc, PDO::PARAM_STR);
                $update->execute();
                $_SESSION['sessionalert'] = "itemedited";
            }
            else{
                $statusMessage = "Error saving item";
                $statusType = "danger";
            }

            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();

        }
        */

        //delete item
        /*
        if(isset($_POST['delete-item-uid'])){
            
            //always delete the central item
            $deleteUID = $_POST['delete-item-uid'];
            $db->exec("DELETE FROM $dbtable WHERE uid = $deleteUID;");

            if(isset($_GET['pid']) && !isset($_GET['sid'])){
                // PID with NO SID means it's a section
                $db->exec("DELETE FROM content WHERE sid = $deleteUID;");
            }
            elseif(!isset($_GET['pid']) && !isset($_GET['sid'])){
                // NO PID with NO SID means it's a page
                $db->exec("DELETE FROM content WHERE pid = $deleteUID;");
                $db->exec("DELETE FROM sections WHERE pid = $deleteUID;");
            }

            $_SESSION['sessionalert'] = "itemdeleted";

            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();

        }
        */

        //generate content from query db
        //$budgets = $db->query("SELECT * FROM budgets WHERE owner = '$_SESSION['email']' ORDER BY uid ASC");
        $budgets = $db->query("SELECT * FROM budgets WHERE owner = 'melanie.s.reeder@gmail.com' ORDER BY uid ASC");

        //reordering save - called via ajax
        /*
        if(isset($_POST['moveuid']) && isset($_POST['movepos'])){
            $moveuid = $_POST['moveuid'];
            $movepos = $_POST['movepos'];

            $posupdate = $db->prepare("UPDATE $dbtable SET pos = :movepos WHERE uid = $moveuid");
            $posupdate->bindParam(':movepos', $movepos, PDO::PARAM_STR);
            $posupdate->execute();
        }
        */

        // close the database connection
        $db = NULL;
    }
    catch(PDOException $e){
        $statusMessage = $e->getMessage();
        $statusType = "danger";
    }

    // remove alert variable
    unset($_SESSION['sessionalert']);

?>