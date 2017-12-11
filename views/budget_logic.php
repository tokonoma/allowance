<?php

    $dashboarduser = $_SESSION['email'];
    
    try{
        //postgres for prod
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //generate content from query db
        $budgetuid = $_GET['budget'];
        $budgettablename = "budget".$budgetuid;

        //budget actions
        if(isset($_POST['budgetaction'])){
                
            $savetype = $_POST['budgetaction'];

            switch ($savetype){
                case 'deduct':
                    //get current balance
                    $currentbalancedata = $db->query("SELECT balance FROM budgets WHERE uid = '$budgetuid'");
                    foreach($currentbalancedata as $getbalance){
                        $input_currentbalance = $getbalance['balance'];
                    }

                    $input_deductamount = $_POST['budget-deduction-input'];
                    $input_deductamount = $input_deductamount*100;
                    $newbalance = $input_currentbalance - $input_deductamount;

                    $input_deductdesc = (!empty($_POST['deduction-desc-input']) ? $_POST['deduction-desc-input'] : "no description");

                    //subtract from balance in budgets table
                    $update = $db->prepare("UPDATE budgets SET balance = :newbalancebind WHERE uid = $budgetuid");
                    $update->bindParam(':newbalancebind', $newbalance, PDO::PARAM_STR);
                    $update->execute();

                    //add transaction to history table
                    $input_deductamount = $input_deductamount;
                    $insert = $db->prepare("INSERT INTO $budgettablename (name, budgetuid, balance, withdraw, deposit, transactiondate, user) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $insertarray = array($input_deductdesc, $budgetuid, $newbalance, $input_deductamount, 0, $currentdate, $dashboarduser);
                    $insert->execute($insertarray);

                    //finish and redirect with success message
                    $_SESSION['sessionalert'] = "generalsuccess";
                    header("Location: ".$_SERVER['REQUEST_URI']."#budget".$budgetuid);
                    exit();

                    break;
                case 'edit':
                    //edit item
                    header("Location: ".$_SERVER['REQUEST_URI']);
                    exit();

                    break;
                case 'delete':
                    //delete item and associated items
                    header("Location: ".$baseurl);
                    exit();

                    break;
            }
            //$statusMessage = "Error saving item";
            //$statusType = "danger";

            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();

        }

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

        //$budgets = $db->query("SELECT * FROM budgets WHERE owner = '$_SESSION['email']' AND uid = $budgetuid ORDER BY uid ASC");
        $thisbudget = $db->query("SELECT * FROM budgets WHERE owner = '$dashboarduser' AND uid = $budgetuid");
        $budgettable = $db->query("SELECT * FROM $budgettablename ORDER BY CAST(uid AS REAL)DESC");

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