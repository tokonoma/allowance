<?php

session_start();
include('system/config.php');
include('system/db_connect.php');

$baseurl  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$baseurl .= $_SERVER['SERVER_NAME'];
if (strpos($baseurl, 'localhost') !== false) {
    $baseurl .= ":".$_SERVER['SERVER_PORT'];
}
//$baseurl .= htmlspecialchars($_SERVER['REQUEST_URI']);
$cleanuri = explode('?', $_SERVER['REQUEST_URI'], 2);
$baseurl .= htmlspecialchars($cleanuri[0]);

try{

    //postgres for prod
    $db = new PDO($dsn);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //delete tool
    //$deleteid = [val];
    //$db->exec("DELETE FROM [table] WHERE [col] = [val]");

    //table create tool
    // $db->exec("CREATE TABLE IF NOT EXISTS users (email TEXT PRIMARY KEY, password TEXT, fname TEXT, lname TEXT)");

    // $db->exec("CREATE TABLE IF NOT EXISTS budgets (uid INTEGER PRIMARY KEY, name TEXT, balance INTEGER, autorefill BOOLEAN, refillamount INTEGER, refillfrequency TEXT, refillon TEXT, nextrefill INTEGER, owner TEXT, shares INTEGER)");

    //$db->exec("CREATE TABLE IF NOT EXISTS budget2 (uid INTEGER PRIMARY KEY, name TEXT, budgetuid INTEGER, balance INTEGER, modifyamount INTEGER, transactiondate TEXT, user TEXT)");

    //$db->exec("CREATE TABLE IF NOT EXISTS shares (uid INTEGER PRIMARY KEY, budgetuid INTEGER, owner TEXT, shareduser TEXT)");

    //add row tool
    // $input_email = "t.reeder03@gmail.com";
    // $input_password = "temppass";
    // $password_store = password_hash($input_password, PASSWORD_BCRYPT);
    // $input_fname = "Tim";
    // $input_lname = "Reeder";

    // $input_email = "melanie.s.reeder@gmail.com";
    // $input_password = "temppass";
    // $password_store = password_hash($input_password, PASSWORD_BCRYPT);
    // $input_fname = "Melanie";
    // $input_lname = "Reeder";

    //FYI $checkpass = password_verify($inputpass, $storedpass) yields t or f for pw check

    // $insert = $db->prepare("INSERT INTO users (email, password, fname, lname) VALUES (?, ?, ?, ?)");
    // $insertarray = array($input_email, $password_store, $input_fname, $input_lname);
    // $insert->execute($insertarray); 

    // $input_budgetname = "Test Budget";
    // $input_balance = 200;
    // $input_autorefill = 1;
    // $input_refillamount = 500w;
    // $input_refillfreq = "weekly";
    // $input_refillon = "friday";
    // $input_nextrefill = 20171208;
    // $input_owner = "t.reeder03@gmail.com";
    // $input_shares = 0;


    // $insert = $db->prepare("INSERT INTO budgets (name, balance, autorefill, refillamount, refillfrequency, refillon, nextrefill, owner, shares) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    // $insertarray = array($input_budgetname, $input_balance, $input_autorefill, $input_refillamount, $input_refillfreq, $input_refillon, $input_nextrefill, $input_owner, $input_shares);
    // $insert->execute($insertarray);

    // $input_transname = "First Transaction";
    // $input_budgetuid = "2";
    // $input_balance = "100";
    // $input_modifyamount = "100";
    // $input_trandate = "20171127";
    // $input_user = "t.reeder03@gmail.com";

    // $insert = $db->prepare("INSERT INTO budget2 (name, budgetuid, balance, modifyamount, transactiondate, user) VALUES (?, ?, ?, ?, ?, ?)");
    // $insertarray = array($input_transname, $input_budgetuid, $input_balance, $input_modifyamount, $input_trandate, $input_user);
    // $insert->execute($insertarray);

    // $input_budgetuid = "1";
    // $input_owner = "melanie.s.reeder@gmail.com";
    // $input_shareduser = "t.reeder03@gmail.com";

    // $insert = $db->prepare("INSERT INTO shares (budgetuid, owner, shareduser) VALUES ( ?, ?, ?)");
    // $insertarray = array($input_budgetuid, $input_owner, $input_shareduser);
    // $insert->execute($insertarray);

    //update row tool
    // $update = $db->prepare("UPDATE [table] SET title = :titleinput, body = :bodyinput WHERE uid = $uid");
    // $update->bindParam(':titleinput', $titleinput, PDO::PARAM_STR);
    // $update->bindParam(':bodyinput', $bodyinput, PDO::PARAM_STR);
    // $update->execute();

    // $input_refill = 150;
    // $update = $db->prepare("UPDATE budgets SET refillamount = :amount WHERE uid = 1");
    // $update->bindParam(':amount', $input_refill, PDO::PARAM_STR);
    // $update->execute();

    //add a column
    //$db->exec("ALTER TABLE budgets ADD COLUMN refillon TEXT");

    //then...
    // $input_new_column_value = Friday;
    // $update = $db->prepare("UPDATE budgets SET refillon = :shares WHERE uid = 2");
    // $update->bindParam(':shares', $input_new_column_value, PDO::PARAM_STR);
    // $update->execute();

    //table delete tool
    //$db->exec("DROP TABLE tablename");

    //row delete tool
    //$db->exec("DELETE FROM budget4 WHERE uid = 2");


    //queries
    // get all tables
    $tables = $db->query("SELECT * FROM sqlite_master where type='table';");

    // loop through all tables and create individual queries
    foreach ($tables as $table) {
        $tablename = $table['name'];
        $tablequery = $tablename . "query";
        $$tablequery = $db->query("SELECT * FROM $tablename");
        $tablearray[$tablename] = $tablequery;
    }

    //$users = $db->query("SELECT * FROM users");

    // close the database connection
    $db = NULL;
}
catch(PDOException $e){
    $statusMessage = $e->getMessage();
    $statusType = "danger";
}

?>

<?php include('views/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-xs-12" style="margin-top: 24px;">

            <?php
                if (!empty($statusMessage)){
                    echo "<div id='' class='alert alert-" . $statusType . " notif-alert' role='alert'>". $statusMessage . "</div>";
                }
            ?>

            <h1>TABLES</h1>

            <? foreach ($tablearray as $tablename => $tablequery): ?>
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading"><?php echo $tablename; ?></div>
                <!-- Table -->
                <table class="table table-striped">

                <?php
                    $firstrow = true;
                    $tablerows = $$tablequery->fetchAll(PDO::FETCH_ASSOC);
                    foreach($tablerows as $tablerow){
                        if($firstrow){
                            foreach($tablerow as $columnvalue => $cellvalue){
                                $columns[] = $columnvalue;
                                $cellvalues[] = $cellvalue;
                            }
                            echo "<thead><tr>";
                            foreach($columns as $column){
                                echo "<th>" . $column . "</th>";
                            }
                            echo "</tr></thead><tbody>";
                            echo "<tr>";
                            foreach($cellvalues as $cellvalue){
                                echo "<td>" . $cellvalue . "</td>";
                            }
                            echo "</tr>";
                        }
                        else{
                            echo "<tr>";
                            foreach($tablerow as $column => $cellvalue){
                                echo "<td>" . $cellvalue . "</td>";
                            }
                            echo "</tr>";
                        }
                        $firstrow = false;
                        unset($columns);
                        unset($cellvalues);
                    }
                ?>
                    </tbody>
                </table>
            </div>
            <? endforeach; ?>

        </div>
    </div>
</div>

<?php include('views/ender.php'); ?>