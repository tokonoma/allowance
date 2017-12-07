<?php

    $dashboarduser = $_SESSION['email'];
    
    try{
        //postgres for prod
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //do while loop for catching up over multiple months
        //maybe we need to create a func for updating refill date

        //https://stackoverflow.com/questions/21735650/php-converting-dollars-to-cents
        
        //define current date
        $currentdate = date("Ymd");
        $currentyear = date("Y");
        $currentmonth = date("m");
        $currentday = date("d");

        //testing
        // $currentday = date("d");
        // $currentmonth = "04";
        // $currentyear = date("Y");

        // echo "current day ".$currentday."<br>";
        // echo "current month ".$currentmonth."<br>";
        // echo "current year ".$currentyear."<br>";

        //budget actions
        if(isset($_POST['budgetaction'])){
                
            $savetype = $_POST['budgetaction'];

            switch ($savetype){
                case 'new':
                    //add row to table
                    $input_budgetname = $_POST['budget-name-input'];
                    $input_balance = $_POST['budget-balance-input'];
                    $input_autorefill = (!empty($_POST['budget-refill-input']) ? $_POST['budget-refill-input'] : 0);
                    //If refill is off, use this to hold original balance
                    $input_refillamount = (!empty($_POST['budget-refill-input']) ? $_POST['refill-amount-input'] : $input_balance);
                    $input_refillfreq = (!empty($_POST['budget-refill-input']) ? $_POST['refill-frequency-input'] : "none");
                    $input_refillfreq = strtolower($input_refillfreq);
                    if($input_refillfreq == "weekly"){
                        $input_refillon = $_POST['refill-weekly-input'];
                        $nextrefillstr = "next ".$input_refillon;
                        $input_nextrefill = date("Ymd", strtotime($nextrefillstr));

                        //all lower for consistent storing
                        $input_refillon = strtolower($input_refillon);
                    }
                    elseif($input_refillfreq == "monthly"){
                        $input_refillon = $_POST['refill-monthly-input'];
                        $input_refillon = sprintf("%02d", $input_refillon);

                        //calculate next refill date
                        //have we already passed the day for this month?
                        if($currentday >= $input_refillon){
                            //do we need to move into 2018?
                            if($currentmonth == 12){
                                $refillmonth = "01";
                                $refillyear = $currentyear + 1;
                            }
                            else{
                                $refillmonth = $currentmonth + 1;
                                $refillmonth = sprintf("%02d", $refillmonth);
                                $refillyear = $currentyear;
                            }
                        }
                        else{
                            $refillmonth = $currentmonth;
                            $refillyear = $currentyear;
                        }
                        $input_nextrefill = $refillyear.$refillmonth.$input_refillon;
                    }
                    else{
                        $input_refillon = "none";
                        $input_nextrefill = 0;
                    }
                    $input_shares = 0;

                    //tests
                    echo "input_budgetname = ".$input_budgetname."<br>";
                    echo "input_balance = ".$input_balance."<br>";
                    echo "input_autorefill = ".$input_autorefill."<br>";
                    echo "input_refillamount = ".$input_refillamount."<br>";
                    echo "input_refillfreq = ".$input_refillfreq."<br>";
                    echo "input_refillon = ".$input_refillon."<br>";
                    echo "input_nextrefill = ".$input_nextrefill."<br>";
                    echo "input_shares = ".$input_shares."<br>";

                    // $insert = $db->prepare("INSERT INTO budgets (name, balance, autorefill, refillamount, refillfrequency, nextrefill, owner) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    // $insertarray = array($input_budgetname, $input_balance, $input_autorefill, $input_refillamount, $input_refillfreq, $input_nextrefill, $input_owner);
                    // $insert->execute($insertarray);

                    //create table for budget
                    break;
                case 'deduct':
                    //deduct from balance item
                    break;
            }
            //$statusMessage = "Error saving item";
            //$statusType = "danger";

            //header("Location: ".$_SERVER['REQUEST_URI']);
            //exit();

        }


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
        $budgets = $db->query("SELECT * FROM budgets WHERE owner = '$dashboarduser' ORDER BY uid ASC");
        //$budgets = $db->query("SELECT * FROM budgets WHERE owner = 'melanie.s.reeder@gmail.com' ORDER BY uid ASC");

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