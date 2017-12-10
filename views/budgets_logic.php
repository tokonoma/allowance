<?php

    $dashboarduser = $_SESSION['email'];

    //define current date
    $currenttimestamp = time();
    $currentdate = date("Ymd");
    $currentyear = date("Y");
    $currentmonth = date("m");
    $currentday = date("d");
    
    try{
        //postgres for prod
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //budget actions
        if(isset($_POST['budgetaction'])){
                
            $savetype = $_POST['budgetaction'];

            switch ($savetype){
                case 'new':
                    //add row to table
                    $input_budgetname = $_POST['budget-name-input'];
                    $input_balance = $_POST['budget-balance-input'];
                    $input_balance = $input_balance*100;
                    $input_autorefill = (!empty($_POST['budget-refill-input']) ? $_POST['budget-refill-input'] : 0);
                    //If refill is off, use this to hold original balance
                    if(!empty($_POST['budget-refill-input'])){
                        $input_refillamount = $_POST['refill-amount-input'];
                        $input_refillamount = $input_refillamount*100;
                    }
                    else{
                        $input_refillamount = $input_balance;
                    }
                    $input_refillfreq = (!empty($_POST['budget-refill-input']) ? $_POST['refill-frequency-input'] : "none");
                    $input_refillfreq = strtolower($input_refillfreq);

                    //calculate next refill
                    if($input_refillfreq == "weekly"){
                        $input_refillon = $_POST['refill-weekly-input'];
                        $input_nextrefill = findRefillDate($currenttimestamp, $input_refillfreq, $input_refillon);

                        //all lower for consistent storing
                        $input_refillon = strtolower($input_refillon);
                    }
                    elseif($input_refillfreq == "monthly"){
                        $input_refillon = $_POST['refill-monthly-input'];
                        $input_refillon = sprintf("%02d", $input_refillon);

                        $input_nextrefill = findRefillDate($currenttimestamp, $input_refillfreq, $input_refillon);
                    }
                    else{
                        $input_refillon = "none";
                        $input_nextrefill = findRefillDate($currenttimestamp, $input_refillfreq, $input_refillon);
                    }
                    $input_shares = 0;

                    //insert into budgets table
                    $insert = $db->prepare("INSERT INTO budgets (name, balance, autorefill, refillamount, refillfrequency, refillon, nextrefill, owner, shares) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insertarray = array($input_budgetname, $input_balance, $input_autorefill, $input_refillamount, $input_refillfreq, $input_refillon, $input_nextrefill, $dashboarduser, $input_shares);
                    $insert->execute($insertarray);

                    //create table for budget
                    $newbudgetuid = $db->lastInsertId();
                    $budgettablename = "budget".$newbudgetuid;
                    $db->exec("CREATE TABLE IF NOT EXISTS $budgettablename (uid INTEGER PRIMARY KEY, name TEXT, budgetuid INTEGER, balance INTEGER, modifyamount INTEGER, transactiondate TEXT, user TEXT)");

                    //log creation of budget into table
                    $input_transactionname = "Budget created";

                    $insert = $db->prepare("INSERT INTO $budgettablename (name, budgetuid, balance, modifyamount, transactiondate, user) VALUES (?, ?, ?, ?, ?, ?)");
                    $insertarray = array($input_transactionname, $newbudgetuid, $input_balance, $input_balance, $currentdate, $dashboarduser);
                    $insert->execute($insertarray);

                    //finish and redirect with success message
                    $_SESSION['sessionalert'] = "budgetcreated";
                    header("Location: ".$_SERVER['REQUEST_URI']);
                    exit();

                    break;
                case 'deduct':
                    //deduct from balance item
                    $input_deductuid = $_POST['deduct-uid'];
                    $budgettablename = "budget".$input_deductuid;

                    $input_currentbalance = $_POST['current-balance'];
                    $input_deductamount = $_POST['budget-deduction-input'];
                    $input_deductamount = $input_deductamount*100;
                    $newbalance = $input_currentbalance - $input_deductamount;

                    $input_deductdesc = (!empty($_POST['deduction-desc-input']) ? $_POST['deduction-desc-input'] : "no description");

                    //subtract from balance in budgets table
                    $update = $db->prepare("UPDATE budgets SET balance = :newbalancebind WHERE uid = $input_deductuid");
                    $update->bindParam(':newbalancebind', $newbalance, PDO::PARAM_STR);
                    $update->execute();

                    //add transaction to history table
                    $insert = $db->prepare("INSERT INTO $budgettablename (name, budgetuid, balance, modifyamount, transactiondate, user) VALUES (?, ?, ?, ?, ?, ?)");
                    $insertarray = array($input_deductdesc, $input_deductuid, $newbalance, $input_deductamount, $currentdate, $dashboarduser);
                    $insert->execute($insertarray);

                    //finish and redirect with success message
                    $_SESSION['sessionalert'] = "generalsuccess";
                    header("Location: ".$_SERVER['REQUEST_URI']."#budget".$input_deductuid);
                    exit();

                    break;
            }
            $statusMessage = "Error saving item";
            $statusType = "danger";

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

        //generate content from query db
        $budgetupdates = $db->query("SELECT * FROM budgets WHERE owner = '$dashboarduser' ORDER BY uid ASC");

        //update any auto refills first
        foreach($budgetupdates as $budget){
            $updatebudgetuid = $budget['uid'];
            $updatebudgetbalance = $budget['balance'];
            $updateautorefill = $budget['autorefill'];
            $updatenextrefill = $budget['nextrefill'];
            $updatefreq = $budget['refillfrequency'];
            $updaterefillon = $budget['refillon'];
            $updateamount = $budget['refillamount'];
            if($updateautorefill == 1){
                while($updatenextrefill <= $currentdate){
                    $nextrefillts = strtotime($updatenextrefill); 
                    $updatebudgetbalance += $updateamount;
                    $updatenextrefill = findRefillDate($nextrefillts, $updatefreq, $updaterefillon);
                    
                    //add new balance to table
                    $updatebudgets = $db->prepare("UPDATE budgets SET balance = :updatebalancebind, nextrefill = :updatenextrefillbind WHERE uid = $updatebudgetuid");
                    $updatebudgets->bindParam(':updatebalancebind', $updatebudgetbalance, PDO::PARAM_STR);
                    $updatebudgets->bindParam(':updatenextrefillbind', $updatenextrefill, PDO::PARAM_STR);
                    $updatebudgets->execute();

                    //add new transaction to budget-specific table
                    $updatebudgettablename = "budget".$updatebudgetuid;
                    $updaterefilldesc = "Auto Refill";
                    $systemuser = "System";
                    $insertupdate = $db->prepare("INSERT INTO $updatebudgettablename (name, budgetuid, balance, modifyamount, transactiondate, user) VALUES (?, ?, ?, ?, ?, ?)");
                    $insertarray = array($updaterefilldesc, $updatebudgetuid, $updatebudgetbalance, $updateamount, $updatenextrefill, $systemuser);
                    $insertupdate->execute($insertarray);
                }
            }
        }

        //generate budgets for list
        $budgets = $db->query("SELECT * FROM budgets WHERE owner = '$dashboarduser' ORDER BY uid ASC");

        //generate shared budgets list
        //$sharedbudgets = $db->query("SELECT * FROM shares WHERE shareduser = '$dashboarduser' ORDER BY uid ASC");

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

    function findRefillDate($now, $freq, $refillon){
        if($freq == "weekly"){
            $nextrefillstr = "next ".$refillon;
            $nextrefill = date("Ymd", strtotime($nextrefillstr, $now));
        }
        elseif($freq == "monthly"){
            //breakapart $now
            $nowyear = date("Y", $now);
            $nowmonth = date("m", $now);
            $nowday = date("d", $now); 
            //have we already passed the day for this month?
            if($nowday >= $refillon){
                //do we need to move into 2018?
                if($nowmonth == 12){
                    $refillmonth = "01";
                    $refillyear = $nowyear + 1;
                }
                else{
                    $refillmonth = $nowmonth + 1;
                    $refillmonth = sprintf("%02d", $refillmonth);
                    $refillyear = $nowyear;
                }
            }
            else{
                $refillmonth = $nowmonth;
                $refillyear = $nowyear;
            }
            $nextrefill = $refillyear.$refillmonth.$refillon;
        }
        else{
            $nextrefill = 0;
        }
        return $nextrefill;
    }           

?>