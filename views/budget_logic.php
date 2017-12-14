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
                    $insert = $db->prepare("INSERT INTO $budgettablename (name, budgetuid, balance, withdraw, deposit, transactiondate, user) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $insertarray = array($input_deductdesc, $budgetuid, $newbalance, $input_deductamount, 0, $currentdate, $dashboarduser);
                    $insert->execute($insertarray);

                    //finish and redirect with success message
                    $_SESSION['sessionalert'] = "generalsuccess";
                    header("Location: ".$_SERVER['REQUEST_URI']);
                    exit();

                    break;
                case 'edit':
                    //edit item
                    header("Location: ".$_SERVER['REQUEST_URI']);
                    exit();

                    break;
                case 'delete':
                    //delete budget from budgets table
                    $db->exec("DELETE FROM budgets WHERE uid = $budgetuid");

                    //delete any shares this budget may have had
                    $db->exec("DELETE FROM budgets WHERE budgetuid = $budgetuid");

                    //delete budgets table
                    $db->exec("DROP TABLE $budgettablename");


                    header("Location: ".$baseurl);
                    exit();

                    break;
                case 'share':
                    //get share email input
                    $input_shareduser = $_POST['share-user-input'];

                    //add to shares
                    $update = $db->prepare("UPDATE budgets SET shares = shares + 1 WHERE uid = $budgetuid");
                    $update->execute();

                    //add share details to share table
                    $insert = $db->prepare("INSERT INTO shares (budgetuid, owner, shareduser) VALUES (?, ?, ?)");
                    $insertarray = array($budgetuid, $dashboarduser, $input_shareduser);
                    $insert->execute($insertarray);

                    //don't forget to get shares on dashboard

                    $_SESSION['sessionalert'] = "generalsuccess";
                    header("Location: ".$_SERVER['REQUEST_URI']);
                    exit();

                    break;
            }
            //$statusMessage = "Error saving item";
            //$statusType = "danger";

            header("Location: ".$_SERVER['REQUEST_URI']);
            exit();

        }

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